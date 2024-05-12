<?php 
namespace app\models;
use app\models\blog_tag;
use app\models\blogs_tags;
use app\models\images;
use electronic\core\model\model;

class blogs extends model
{

    protected function fullAll()
    {
        $data = $this->all();
        
        foreach($data as &$i){
            $this->full($i); 
        }
        
        return $data;
    }

    protected function fullGet()
    {
        $i = $this->get();
        if($i){
            $this->full($i);
        }
        return $i;
    }

    private function full(&$i)
    {
        $i->categories = [];
        $i->tags = [];
        $im = (new images)->where('blog_id', $i->id)->all(); 
        if($im){
            $i->images = $im;
        }

        $tag = (new blog_tag)->where('blog_id', $i->id)->all();
        foreach($tag as $ii){
            $b = (new blogs_tags)->find($ii->tag_id);
            if($b){
                $i->tags[] = $b;
            }
        }
    }

    public function __get($param)
    {
        dd(0);
        return '';
    }
}
