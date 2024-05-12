<?php 
namespace app\controllers\blogs;

use app\models\blogs;
use app\models\blogs_categories;
use app\controllers\controller;
use electronic\core\view\view;
use app\controllers\error\error;
use system\core\app\app;

class blogsController extends controller
{
    public function index()
    {
        $blog = (new blogs)->where('url', request('get', 'url'))->fullGet();

        if(!$blog){
            (new error())->error404();
            exit();
        }

        $this->bc(lang('blogs', 'blogs'), '/blogs');

        $bcp = (new blogs_categories)->bc($blog->category_id, true);
        
        foreach($bcp as $i){
            $this->bc($i->name, '/blogs/category/' . $i->url);
        }
        $this->bc($blog->name, '/blogs/' . $blog->url);
        $this->return($blog);
        $this->title($blog->title);
        if($blog->image_id){
            $this->data['meta_images'] = $this->siteUrl .'/images/thumbnail/normal/' . $blog->image_id . '.png';
        }
        if(!empty($blog->description)){
            $this->data['meta_description'] = $blog->description;
        }

        $postsCategory = (new blogs)->whereIn('category_id', (new blogs_categories)->treeArray($blog->category_id))
            ->where('active', 1)
            ->sort('asc', 'sort')
            ->all();
        $this->data['blog'] = $blog;
        $this->data['postsCategory'] = $postsCategory;
        $this->data['rootCategory'] = (new blogs_categories)->tree($bcp ? $bcp[0]->id : null);
        new view('blogs/blogs/index', $this->data);
    }
}
