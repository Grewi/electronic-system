<?php

namespace app\controllers\admin\blogs;

use app\models\blogs;
use app\models\blog_category;
use app\models\blogs_categories;
use app\models\blogs_tags;
use app\models\blog_tag;
use app\models\images;
use app\models\image_size;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;
use system\core\app\app;

class blogsController extends controller
{
    public function index()
    {
        $app = app::app();

        $blogs = (new blogs)->select('*');

        if($app->getparams->category_id){
            $categories = (new blogs_categories)->treeArray($app->getparams->category_id);
            $blogs->whereIn('category_id', $categories);
        }

        $this->bc(lang('blogs', 'blogs'), '/admin/blogs');
        $category = (new blogs_categories)->find($app->getparams->category_id);
        if ($category) {
            if ($category->parent_id) {
                $bcp = (new blogs_categories)->bc($category->parent_id, true);
                foreach ($bcp as $i) {
                    $this->bc($i->name, '/admin/blogs/' . $i->id);
                }
            }
            $this->bc($category->name, '/admin/blogs/' . $category->id);
            $parents = (new blogs_categories)->where('parent_id', $category->id)->sort('asc', 'sort')->all();
        }else{
            $parents = (new blogs_categories)->whereNull('parent_id')->sort('asc', 'sort')->all();
        }

        if($category && $category->sort_post){
            $blogs->sort('asc', $category->sort_post)->pagin(null, false);
        }else{
            $blogs->sort('desc', 'blogs.date_create')->pagin(null, false);
        }
        

        $this->title('');
        $this->data['blogs'] = $blogs->all();
        $this->data['pagin'] = $blogs->pagination();
        $this->data['parents'] = $parents;
        new view('admin/blogs/blogs/index', $this->data);
    }

    public function create()
    {
        $this->title('Новая запись');
        new view('admin/blogs/blogs/create', $this->data);
    }    

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('blogCreate');
        $valid->name('name')->text()->empty();
        $valid->name('title')->text();
        $valid->name('url')->latInt()->unique('blogs', 'url');
        $valid->name('description')->text();

        $url = empty($valid->return('url')) ? translit_slug($valid->return('name')) : $valid->return('url');
        $issetUrl = (new blogs)->where('url', $url)->all();
        if(count($issetUrl) > 0){
            $url = $url . '-' . time();
        }

        if(!$valid->control()){
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        $data = [
            'user_id' => user_id(),
            'title' => empty($valid->return('title')) ? $valid->return('name') : $valid->return('title'),
            'description' => $valid->return('description'),
            'url' => $url,
            'name' => $valid->return('name'),
            'active' => 0,
            'content' => '',
            'sort' => 0,
        ];
        $blog = (new blogs)->insert($data);
        redirect('/admin/blogs/edit/' . $blog->id . '?referal=' . referal_url());
    }


    public function update()
    {
        $blog = (new blogs)->find(request('get', 'blog_id'));
        $images = (new images)->selectRelation('blog', $blog->id)->all();

        //Временно!
        if(!$blog->category_id){
            $blog_category = (new blog_category)->where('blog_id', $blog->id)->get();
            if($blog_category){
                $blog->category_id = $blog_category->category_id;
                $blog->save();
            }
        }

        $this->return($blog);
        $this->title('Редактирование записи');
        $this->data['images'] = $images;
        $this->data['blogCategories'] = (new blogs_categories)->all();
        $this->data['imagesSizes'] = (new image_size)->all();
        $this->data['blogTags'] = (new blogs_tags)->all();
        $this->data['categoriesTree'] = (new blogs_categories)->tree();
        new view('admin/blogs/blogs/update', $this->data);
    }

    public function updateAction()
    {
        $blog = (new blogs)->find(request('get', 'blog_id'));
        $valid = new validate();
        $valid->name('csrf')->csrf('blogCreate');
        $valid->name('referal')->url();
        $valid->name('title')->text();
        $valid->name('image')->int();
        $valid->name('description')->text();
        $valid->name('category')->isset('blogs_categories');
        $valid->name('url')->latInt()->unique('blogs', 'url', $blog->id);
        $valid->name('name')->text();
        $valid->name('active')->bool();
        $valid->name('content')->text();
        $valid->name('telegram')->bool();

        if (isset($_POST['tag']) && is_array($_POST['tag'])) {
            foreach ($_POST['tag'] as $tag) {
                $valid->name('tag' . $tag, $tag)->isset('blogs_tags');
            }
        }

        if (!$valid->control() || !$blog) {
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        try {

            if (!empty($_FILES['image']['tmp_name'])) {
                $data = [
                    'blog_id' => $blog->id,
                ];
                (new images)->upload($data, $_FILES['image']);
            }

            if (empty($valid->return('url')) || is_numeric($valid->return('url'))) {
                $url = $blog->id . '-' . translit_slug($valid->return('title'));
            } else {
                $url = $valid->return('url');
            }

            $name = $valid->return('name') == 'Наименование' ? $valid->return('title') : $valid->return('name');

            $data = [
                'id' => $blog->id,
                'user_id' => user_id(),
                'image_id' => $valid->return('image'),
                'category_id' => $valid->return('category'),
                'title' => $valid->return('title'),
                'description' => $valid->return('description'),
                'url' => $url,
                'name' => $name,
                'active' => $valid->return('active'),
                'content' => $valid->return('content'),
            ];
            (new blogs)->update($data);

            (new blog_tag)->where('blog_id', $blog->id)->delete();
            if (isset($_POST['tag']) && is_array($_POST['tag'])) {
                foreach ($_POST['tag'] as $tag) {
                    (new blog_tag)->insert([
                        'blog_id' => $blog->id,
                        'tag_id' => $tag,
                    ]);
                }
            }

            if ($valid->return('telegram')) {
                $this->telegram(
                    '<b>' . $valid->return('title') . '</b>' . PHP_EOL,
                    $valid->return('content'),
                    ROOT . '/public/images/original/' . $valid->return('image') . '.png',
                    $valid->return('url'),
                    $valid->return('description'),
                );
            }

            alert('Запись создана', 'success');
            if (isset($_POST['save_and_next'])) {
                redirect('/admin/blogs/edit/' . $blog->id);
            } else {
                redirect($valid->return('referal'));
            }
        } catch (\Exception $e) {
            dd($e);
            alert('Сохранить не удалось', 'danger');
            redirect('/admin/blogs/edit/' . $blog->id, $valid->data(), $valid->error());
        }
    }

    public function delete()
    {
        $blog = (new blogs)->find(request('get', 'blog_id'));
        $this->return($blog);
        $this->title('Удалить запись');
        new view('admin/blogs/blogs/delete', $this->data);
    }

    public function deleteAction()
    {
        $blog = (new blogs)->find(request('get', 'blog_id'));
        $blog->delete();
        alert('Запись удалена', 'success');
        redirect('/admin/blogs');
    }

    private function telegram($title, $content, $image, $url, $description)
    {
        $chat_id   = '-10000000000';
        $token     = '1272029330:--------';
        $whiteList = '<b><a><i><em><strong><code><pre>';
        $content = htmlspecialchars_decode($title . $content);
        $content = str_replace('&nbsp;', ' ', $content);
        $content = str_replace('<br>', PHP_EOL, $content);
        $content = str_replace('</p>', '</p>' . PHP_EOL, $content);
        $content = str_replace('</div>', '</div>' . PHP_EOL, $content);
        $content = strip_tags($content, $whiteList);

        $caption = 'Читайте на нашем сайте: <a href="http://grewi.ru/blogs/' . $url . '">' . $title . '</a>' . PHP_EOL . $description;

        $post_fields = [
            'chat_id' => $chat_id,
            'caption' => $caption,
            'photo'   => new \CURLFile($image),
            "parse_mode" => "html"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type:multipart/form-data"
        ));
        curl_setopt($ch, CURLOPT_URL, 'https://api.telegram.org/bot' . $token . '/' . 'sendPhoto?chat_id=' . $chat_id);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
        $output = curl_exec($ch);
        curl_close($ch);

        if (mb_strlen($content) > 1000) {
            $post_fields = [
                "chat_id"      => $chat_id,
                "text"       => $content,
                "parse_mode" => "html"
            ];

            $ch = curl_init("https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
            $output = curl_exec($ch);
            curl_close($ch);
            // dump($post_fields); 
        }
    }

    private function categoriesTree($arr)
    {
        $str = '<ul>';
        foreach ($arr as $i) {
            $str .= '<li>' . $i->name . '</li>';
            if ($i->children) {
                $str .= $this->categoriesTree($i->children);
            }
        }
        $str .= '</ul>';
        return $str;
    }

    public function sortAction()
    {

        if (isset($_POST['sort']) && is_array($_POST['sort'])) {
            $error = false;
            foreach ($_POST['sort'] as $a => $i) {
                if (is_numeric($i)) {
                    $b = (new blogs)->where('id', $a)->update(['sort' => (int)$i]);
                    if (!$b) {
                        $error = true;
                    }
                } else {
                    $error = true;
                }
            }
            if ($error) {
                alert('Выполненно с ошибками', 'danger');
            } else {
                alert('Сохранено', 'success');
            }
        }
        redirect(referal_url());
    }
}
