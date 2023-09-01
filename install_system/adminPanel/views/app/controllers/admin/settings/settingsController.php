<?php

namespace app\controllers\admin\settings;

use app\models\settings;
use app\models\settings_category;
use app\models\settings_type;
use app\controllers\admin\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;

class settingsController extends controller
{
    public function index()
    {
        $this->bc(lang('admin', 'settings'));
        $this->title(lang('admin', 'settings'));
        $this->data['categories'] = settings_category::sort('asc', 'name')->all();
        new view('admin/settings/settings/index', $this->data);
    }

    public function settings()
    {
        $category = settings_category::find(request('get')->caegory_id);
        if(!$category){
            redirect(referal_url());
        }
        $settings = settings::where('setting_category_id', $category->id)->pagin();
        $this->title('');
        $this->bc(lang('admin', 'settings'), '/' . ADMIN . '/settings');
        $this->bc($category->name);
        $this->data['settings'] = $settings->all();
        $this->data['pagin'] = $settings->pagination;
        $this->data['category'] = $category;
        new view('admin/settings/settings/settings', $this->data);
    }

    public function save()
    {
        if (!isset($_POST['setting']) || !is_iterable($_POST['setting'])) {
            redirect(referal_url());
        }
        foreach ($_POST['setting'] as $a => $value) {
            $s = settings::find($a);
            if ($s) {
                $s->value = $value;
                $s->save();
            }
        }
        redirect(referal_url());
    }

    // Category 

    public function createCategory()
    {
        $this->title(lang('admin', 'addCategory'));
        $this->bc(lang('admin', 'settings'), '/' . ADMIN . '/settings');
        $this->bc(lang('admin', 'addCategory'));
        new view('admin/settings/categorySettings/create', $this->data);
    }

    public function createCategoryAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('addCategory');
        $valid->name('name')->latRuInt()->empty();

        if($valid->control()){
            settings_category::insert($valid->return());
            redirect('/' . ADMIN . '/settings');
        }else{
            dd($valid);
            redirect(referal_url());
        }
    }

    public function updateCategory()
    {
        $category = settings_category::find(request('get')->setting_id);
        if(!$category){
            redirect(referal_url());
        }
        $this->title(lang('admin', 'editCategory'));
        $this->bc(lang('admin', 'settings'), '/' . ADMIN . '/settings');
        $this->bc(lang('admin', 'editCategory'));
        $this->data['category'] = $category;
        new view('admin/settings/categorySettings/update', $this->data);
    }

    public function updateCategoryAction()
    {
        $category = settings_category::find(request('get')->setting_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('editCategory');
        $valid->name('name')->latRuInt()->empty();

        if($valid->control() && $category){
            $category->update($valid->return());
            redirect('/' . ADMIN . '/settings');
        }else{
            dd($valid);
            redirect(referal_url());
        }
    }

    public function deleteCategory()
    {
        $category = settings_category::find(request('get')->setting_id);
        if(!$category){
            redirect(referal_url());
        }
        $this->title(lang('admin', 'deleteCategory'));
        $this->bc(lang('admin', 'settings'), '/' . ADMIN . '/settings');
        $this->bc(lang('admin', 'deleteCategory'));
        $this->data['category'] = $category;
        new view('admin/settings/categorySettings/delete', $this->data);
    }

    public function deleteCategoryAction()
    {
        $category = settings_category::find(request('get')->setting_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('categoryDelete');

        if($valid->control() && $category){
            settings::where('setting_category_id', $category->id)->delete();
            $category->delete();
            redirect('/' . ADMIN . '/settings');
        }else{
            dd($valid);
            redirect(referal_url());
        }
    }

    // Menager setting

    public function create()
    {
        if(request('get')->category_id){
            $category = settings_category::find(request('get')->category_id);
        }
        $this->title(lang('admin', 'addSetting'));
        $this->bc(lang('admin', 'settings'), '/' . ADMIN . '/settings');
        if($category){
            $this->bc($category->name, '/' . ADMIN . '/settings/' . $category->id);
        }
        $this->bc(lang('admin', 'addSetting'));
        $this->data['settingCategory'] = settings_category::all();
        $this->data['settingsType'] = settings_type::all();
        $this->data['categoryParent'] = $category;
        new view('admin/settings/managerSettings/create', $this->data);
    }

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('addSetting');
        $valid->name('setting_category_id')->isset('settings_category');
        $valid->name('setting_type_id')->isset('settings_type');
        $valid->name('name')->latRuInt()->empty();
        $valid->name('description')->text();
        $valid->name('value')->text();

        if($valid->control()){
            settings::insert($valid->return());
            redirect('/' . ADMIN . '/settings/' . $valid->return('setting_category_id'));
        }else{
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function update()
    {
        $setting = settings::find(request('get')->setting_id);
        if(!$setting){
            redirect(referal_url());
        }
        $category = settings_category::find($setting->setting_category_id);
        $this->title(lang('admin', 'editSetting'));
        $this->bc(lang('admin', 'settings'), '/' . ADMIN . '/settings');
        $this->bc($category->name, '/' . ADMIN . '/settings/' . $category->id);
        $this->bc(lang('admin', 'editSetting'));
        $this->data['setting'] = $setting;
        $this->data['settingCategory'] = settings_category::all();
        $this->data['settingsType'] = settings_type::all();
        new view('admin/settings/managerSettings/update', $this->data);
    }

    public function updateAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('editSetting');
        $valid->name('setting_category_id')->isset('settings_category');
        $valid->name('setting_type_id')->isset('settings_type');
        $valid->name('name')->latRuInt()->empty();
        $valid->name('description')->text();
        $valid->name('value')->text()->empty();
        $setting = settings::find(request('get')->setting_id);
        if(!$setting){
            redirect(referal_url());
        }
        if($valid->control()){
            $setting->update($valid->return());
            redirect('/' . ADMIN . '/settings/' . $valid->return('setting_category_id'));
        }else{
            redirect(referal_url(), $valid->data(), $valid->error());
        }
    }

    public function delete()
    {
        $setting = settings::find(request('get')->setting_id);
        if(!$setting){
            redirect(referal_url());
        }
        $category = settings_category::find($setting->setting_category_id);
        $this->title(lang('admin', 'deleteSetting'));
        $this->bc(lang('admin', 'settings'), '/' . ADMIN . '/settings');
        $this->bc($category->name, '/' . ADMIN . '/settings/' . $category->id);
        $this->bc(lang('admin', 'deleteSetting'));
        $this->data['setting'] = $setting;
        new view('admin/settings/managerSettings/delete', $this->data);
    }

    public function deleteAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('settingDelete');
        if($valid->control()){
            $setting = settings::find(request('get')->setting_id);
            if(!$setting){
                redirect(referal_url());
            }
            $setting->delete();
            redirect('/' . ADMIN . '/settings/' . $setting->setting_category_id);
        }
    }

}
