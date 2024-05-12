<?php 
namespace app\controllers\admin\images;

use app\models\images;
use app\controllers\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;
use system\core\app\app;

class imagesController extends controller
{
    public function index()
    {
        $images = (new images)->pagin();
        $this->title('');
        $this->data['images'] = $images->all();
        $this->data['pagin']  = $images->pagination();
        new view('admin/images/images/index', $this->data);
    }

    public function create()
    {
        $this->title('');
        new view('admin/images/images/create', $this->data);
    }

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('imageCreate');
        $valid->name('name')->text();
        $valid->name('description')->text();

        if(!$valid->control()){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }
        $data = [
            'name' => $valid->return('name'),
            'description' => $valid->return('description'),
        ];
        if($r = (new images)->upload($data, $_FILES['image'])){
            alert($r, 'danger');
            redirect(referal_url());
        }

        alert('Успешно', 'success');
        redirect('/' . ADMIN . '/images');
    }    

    public function update()
    {
        $app = app::app();
        $image = (new images)->find($app->getparams->param_id);
        $this->return($image);
        $this->title('');
        new view('admin/images/images/update', $this->data);
    }

    public function updateAction()
    {
        $app = app::app();
        $image = (new images)->find($app->getparams->param_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('imageEdit');
        $valid->name('name')->text();
        $valid->name('description')->text();

        if(!$valid->control() || !$image){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        $image->name = $valid->return('name');
        $image->description = $valid->return('description');
        $image->save();

        alert('Успешно', 'success');
        redirect(referal_url());
    }     

    public function delete()
    {
        $image = (new images)->find(request('get', 'param_id'));
        $valid = new validate();
        $valid->name('referal')->url();
        $this->title('Удалить изображение');
        $this->data['image'] = $image;
        $this->data['referal'] = $valid->return('referal');
        new view('admin/images/images/delete', $this->data);
    }

    public function deleteAction()
    {
        $app = app::app();
        $image = (new images)->find($app->getparams->param_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('imageDel');
        $valid->name('referal')->url();

        if(!$valid->control() || !$image){
            alert('Ошибка сохранения', 'danger');
            redirect(referal_url(), $valid->data(), $valid->error());
        }

        $image->deleteFiles();

        alert('Успешно', 'success');
        redirect($valid->return('referal'));
    } 


}
