<?php

namespace app\controllers\blogs;

use app\models\blogs;
use app\models\blogs_categories;
use app\models\blogs_tags;
use app\controllers\controller;
use electronic\core\view\view;
use app\controllers\error\error;
use system\core\app\app;

class indexController extends controller
{
    public function index()
    {
        $blogs = (new blogs)->where('active', 1)->sort('desc', 'date_create')->pagin(12);
        $this->title('Дневник PHP');
        $this->bc(lang('blogs', 'blog'));
        $this->data['blogs'] = $blogs->fullAll();
        $this->data['pagin'] = $blogs->pagination();
        $this->data['rootCategory'] = (new blogs_categories)->whereNull('parent_id')->where('active', 1)->sort('asc', 'sort')->all();
        $this->data['allTags'] = (new blogs_tags)->where('active', 1)->all();
        new view('blogs/index/index', $this->data);
    }

    public function category()
    {
        $app = app::app();
        $category = (new blogs_categories)->where('url', $app->getparams->url)->get();
        
        if (!$category) {
            (new error())->error404();
            exit();
        }
        $categoriesArray = (new blogs_categories)->treeArray($category->id);
       
        if(count($categoriesArray) < 1){
            $categoriesArray = [0];
        }

        $blogs = (new blogs)->where('active', 1)->whereIn('category_id', $categoriesArray);

            if($category && $category->sort_post){
                $blogs->sort('asc', $category->sort_post)->pagin(12, false);
            }else{
                $blogs->sort('desc', 'blogs.date_create')->pagin(12, false);
            }

        $this->bc('Блог', '/blogs');
        $bcp = (new blogs_categories)->bc($category->id, true);
        foreach ($bcp as $i) {
            $this->bc($i->name, '/blogs/category/' . $i->url);
        }

        $this->title($category->name);
        $this->data['blogs'] = $blogs->fullAll();
        $this->data['pagin'] = $blogs->pagination();
        $this->data['category'] = $category;
        $this->data['rootCategory'] = (new blogs_categories)->where('parent_id', $category->id)->where('active', 1)->sort('asc', 'sort')->all();
        if($category->parent_id){
            $this->data['neighboringCategory'] = (new blogs_categories)->where('parent_id', $category->parent_id)->where('active', 1)->sort('asc', 'sort')->all();
        }else{
            $this->data['neighboringCategory'] = (new blogs_categories)->whereNull('parent_id')->where('active', 1)->sort('asc', 'sort')->all();
        }
        
        new view('blogs/index/category', $this->data);
    }

    public function tag()
    {
        $tag = (new blogs_tags)->where('url', request('get', 'url'))->get();
        if (!$tag) {
            (new error())->error404();
            exit();
        }
        $blogs = (new blogs)->where('active', 1)
            ->leftJoin('blog_tag', 'blog_tag.blog_id', 'blogs.id')
            ->where('blog_tag.tag_id', $tag->id)
            ->sort('desc', 'blogs.date_create')
            ->pagin(12);

        $this->bc('Блог', '/blogs');
        $this->bc($tag->name);

        $this->title($tag->name);
        $this->data['blogs'] = $blogs->fullAll();
        $this->data['pagin'] = $blogs->pagination();
        $this->data['tag'] = $tag;
        new view('blogs/index/tag', $this->data);
    }
}
