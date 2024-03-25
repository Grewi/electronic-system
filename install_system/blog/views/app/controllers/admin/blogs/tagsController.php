<?php 
namespace app\controllers\admin\blogs;
use app\models\blogs_tags;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;

class tagsController extends controller
{
    public function index()
    {
        $tags = blogs_tags::where('active', 1)->pagin();
        $this->title('Теги');
        $this->data['tags'] = $tags->all();
        $this->data['pagin'] = $tags->pagination();
        new view('admin/blogs/tags/index', $this->data);
    }

    public function create()
    {
        $this->title('');
        new view('admin/blogs/tags/create', $this->data);
    }

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('tagCreate');
        $valid->name('title')->text();
        $valid->name('description')->text();
        $valid->name('url')->latInt();
        $valid->name('name')->text();
        $valid->name('active')->bool();
        $valid->name('referal')->url();

        if(!$valid->control()){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        $data = [
            'title' => $valid->return('title'),
            'description' => $valid->return('description'),
            'url' => $valid->return('url'),
            'name' => empty($valid->return('name')) ? $valid->return('title') : $valid->return('name'),
            'active' => $valid->return('active'),
        ];

        $c = blogs_tags::insert($data);
        if(empty($c->url)){
            $u = translit_slug($c->name);
            $c->url = blogs_tags::where('url', $u)->get() ? $c->id . '-' . $u : $u;
            $c->save();
        }

        alert('Категория создана', 'success');
        redirect($valid->return('referal'));
    }

    public function update()
    {
        $this->title('Редактирование тега');
        $tag = blogs_tags::find(request('get', 'tag_id'));
        $this->return($tag);
        new view('admin/blogs/tags/update', $this->data);
    }

    public function updateAction()
    {
        $tag = blogs_tags::find(request('get', 'tag_id'));
        $valid = new validate();
        $valid->name('csrf')->csrf('tagUpdate');
        $valid->name('title')->text();
        $valid->name('description')->text();
        $valid->name('url')->latInt();
        $valid->name('name')->text();
        $valid->name('active')->bool();
        $valid->name('referal')->url();
        
        if(!$valid->control() || !$tag){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        $tag->title = $valid->return('title');
        $tag->description = $valid->return('description');
        $tag->url = $valid->return('url');
        $tag->name = $valid->return('name');
        $tag->active = $valid->return('active');
        $tag->save();

        alert('Тег обновлён', 'success');
        redirect($valid->return('referal'));
    }

    public function delete()
    {
        $this->title('Удалить тег');
        $tag = blogs_tags::find(request('get', 'tag_id'));
        $this->return($tag);
        new view('admin/blogs/tags/delete', $this->data);
    }

    public function deleteAction()
    {
        $tag = blogs_tags::find(request('get', 'tag_id'));
        try{
            blogs_tags::where($tag->id)->delete();
            redirect('/admin/blogs/tags');
        }catch(\Exception $e){
            redirect(referal_url());
        }
    }

    public function sortAction()
    {
        
        if(isset($_POST['sort']) && is_array($_POST['sort'])){
            $error = false;
            foreach($_POST['sort'] as $a => $i){
                if(is_numeric($i)){
                    $b = blogs_tags::where('id', $a)->update(['sort' => (int)$i]);
                    if(!$b){
                        $error = true;
                    }
                }else{
                    $error = true;
                } 
            }
            if($error){
                alert('Выполненно с ошибками', 'danger');
            }else{
                alert('Сохранено', 'success');
            }
        }
        redirect(referal_url());
    }
}
