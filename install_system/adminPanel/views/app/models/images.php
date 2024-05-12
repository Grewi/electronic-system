<?php 
namespace app\models;

use app\models\image_size;
use electronic\core\model\model;

class images extends model
{
    private $relationType = [
            'post' => 'post_id',
            'blog' => 'blog_id',
        ];

    protected function selectRelation($relationType, $relationId)
    {
        if(!isset($this->relationType[$relationType])){
            return [];
        }
        return $this->where($this->relationType[$relationType], $relationId)->where('active', 1);
    }

    protected function upload($data, $file)
    {
        $image = $this->insert($data);
        $handle = new \Verot\Upload\Upload($file, 'ru_RU');
        if ($handle->uploaded) {
            $fileName = $image->id;
            $handle->dir_chmod            = 0755;
            $handle->allowed              = ['image/*'];
            $handle->image_convert        = 'png';
            $handle->file_new_name_body   = $fileName;
            // $handle->image_x              = 1000;
            // $handle->image_y              = 1000;
            // $handle->image_resize         = true;
            // $handle->image_ratio_y        = true;
            // $handle->image_no_enlarging   = true;
            $handle->process(ROOT . '/public/images/original/');
        }
        

        if ($handle->processed) {
            $fn = $fileName . '.png';
            $image->url = '/images/original/' . $fn;
            $image->save();
            return ;
        }else{
            $image->delete();
            return $handle->error;
        }
    }

    protected function deleteFiles()
    {
        $sizes = (new image_size)->all();
        $name = $this->id;
        foreach($sizes as $size){
            $path = ROOT . '/public/images/thumbnail/' . $size->slug . '/' . $name . '.png';
            if(file_exists($path)){
                unlink($path);
            }
        }
        $path = ROOT . '/public/images/original/' . $name . '.png';
        if(file_exists($path)){
            unlink($path);
        }   

        if($this->id){
            $this->where($this->id);
        }            
        $sql = 'DELETE FROM `images` ' .  $this->_where;
        db($this->_databaseName)->query($sql, $this->_bind);
    }
}
