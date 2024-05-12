<?php 
namespace app\controllers\admin\blogs;

use app\models\blogs;
use app\models\blogs_categories;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;
use app\controllers\error\error;

class categoriesController extends controller
{
    public function index()
    {

        $bc = (new blogs_categories)->find(request('get', 'parent_id') ?? 0);

        if(request('get', 'parent_id') && !$bc){
            (new error())->error404();
            exit();
        }
        $parent = null;
        $this->bc('Категории', '/admin/blogs/categories/');
        if($bc){
            $categories = (new blogs_categories)->where('parent_id', $bc->id)->pagin();
            $parent = $bc->id;

            $bcp = (new blogs_categories)->bc($parent, true);
            
            foreach($bcp as $i){
                $this->bc($i->name, '/admin/blogs/categories/' . $i->id);
            }

        }else{
            $categories = (new blogs_categories)->whereNull('parent_id')->pagin();
        }

        $categories->sort('asc', 'sort');

        $this->title('Категории');
        $this->data['categories'] = $categories->all();
        $this->data['pagin'] = $categories->pagination();
        $this->data['parent'] = $parent;
        new view('admin/blogs/categories/index', $this->data);
    }

    public function create()
    {
        $bc = (new blogs_categories)->find(request('get', 'parent_id') ?? 0);
        if(request('get', 'parent_id') && !$bc){
            (new error())->error404();
            exit();
        }
        $this->title('Создать новую категорию');
        new view('admin/blogs/categories/create', $this->data);
    }

    public function createAction()
    {
        $bc = (new blogs_categories)->find(request('get', 'parent_id') ?? 0);
        if(request('get', 'parent_id') && !$bc){
            (new error())->error404();
            exit();
        }
        $parent =  $bc ? $bc->id : null;

        $valid = new validate();
        $valid->name('csrf')->csrf('categoryCreate');
        $valid->name('title')->text()->empty();
        $valid->name('description')->text();
        $valid->name('url')->latInt();
        $valid->name('name')->text();
        $valid->name('active')->bool();
        $valid->name('referal')->url();
        $valid->name('sort_post')->text();

        if(!$valid->control()){
            dd($valid);
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        $sortPostArray = ['id', 'date_create', 'sort'];

        $data = [
            'parent_id' => $parent,
            'title' => $valid->return('title'),
            'description' => $valid->return('description'),
            'url' => $valid->return('url'),
            'name' => empty($valid->return('name')) ? $valid->return('title') : $valid->return('name'),
            'active' => $valid->return('active'),
            'sort_post' => in_array($valid->return('sort_post'), $sortPostArray) ? $valid->return('sort_post') : null,
        ];

        $c = (new blogs_categories)->insert($data);
        if(empty($c->url)){
            $u = translit_slug($c->name);
            $c->url = (new blogs_categories)->where('url', $u)->get() ? $c->id . '-' . $u : $u;
            $c->save();
        }
        alert('Категория создана', 'success');
        redirect($valid->return('referal'));
    }

    public function update()
    {
        $category = (new blogs_categories)->find(request('get', 'category_id'));
        $this->title('Редактировать категорию');
        $this->return($category);
        $this->data['category'] = $category;
        new view('admin/blogs/categories/update', $this->data);
    }

    public function updateAction()
    {
        $category = (new blogs_categories)->find(request('get', 'category_id'));
        $valid = new validate();
        $valid->name('csrf')->csrf('categoryCreate');
        $valid->name('title')->text();
        $valid->name('description')->text();
        $valid->name('url')->latInt();
        $valid->name('name')->text();
        $valid->name('active')->bool();
        $valid->name('referal')->url();
        $valid->name('sort_post')->text();

        if(!$valid->control() || !$category){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        $sortPostArray = ['id', 'date_create', 'sort'];

        $category->title = $valid->return('title');
        $category->description = $valid->return('description');
        $category->url = $valid->return('url');
        $category->name = $valid->return('name');
        $category->active = $valid->return('active');
        $category->sort_post = in_array($valid->return('sort_post'), $sortPostArray) ? $valid->return('sort_post') : null;
        $category->save();

        alert('Категория обновлена!', 'success');
        redirect($valid->return('referal'));
    }

    public function delete()
    {
        $this->title('Удалить тег');
        $category = (new blogs_categories)->find(request('get', 'tag_id'));
        $this->return($category);
        new view('admin/blogs/categories/delete', $this->data);
    }

    public function deleteAction()
    {
        $category = (new blogs_categories)->find(request('get', 'category_id'));
        try{
            (new blogs_categories)->where($category->id)->delete();
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
                    $b = (new blogs_categories)->where('id', $a)->update(['sort' => (int)$i]);
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
