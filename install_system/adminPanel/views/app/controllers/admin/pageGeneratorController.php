<?php

namespace app\controllers\admin;

use app\models\page_generator;
use app\models\data_page_generator;
use app\controllers\admin\controller;
use electronic\core\view\view;
use electronic\core\validate\validate;

class pageGeneratorController extends controller
{
    private $listTypeData = [
        1 => 'int',
        2 => 'string',
        3 => 'json',
    ];

    public function index()
    {
        $pages = page_generator::pagin();
        $this->title(lang('admin', 'pageGenerator'));
        $this->bc(lang('admin', 'pageGenerator'), '');
        $this->data['PGSubMenu'] = true;
        $this->data['pages'] = $pages->all();
        $this->data['pagin'] = $pages->pagination();
        new view('admin/pageGenerator/index', $this->data);
    }

    public function pgList()
    {
        $page = page_generator::find(request('get')->pg_id);
        $datas = data_page_generator::where('page_id', $page->id)->all();
        $this->bc(lang('admin', 'pageGenerator'), '/' . ADMIN . '/pg/');
        $this->bc($page->name, '/' . ADMIN . '/pg/data/' . $page->id);
        $this->bc(lang('admin', 'data'));
        $this->data['datas'] = $datas;
        $this->data['page'] = $page;
        new view('admin/pageGenerator/data/index', $this->data);
    }

    public function pgAddData()
    {
        $page = page_generator::find(request('get')->pg_id);
        $this->bc(lang('admin', 'pageGenerator'), '/admin/pg/');
        $this->bc($page->name, '/' . ADMIN . '/pg/data/' . $page->id);
        $this->bc(lang('admin', 'addData'));
        $this->data['page'] = $page;
        $this->data['listTypeData'] = $this->listTypeData;
        new view('admin/pageGenerator/data/create', $this->data);
    }

    public function pgListSave()
    {
        $page = page_generator::find(request('get')->pg_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('pgData');
        $valid->name('name')->text();
        $valid->name('type')->empty();
        $valid->name('value')->empty();
        if($page && $valid->control() && array_key_exists($valid->return('type'), $this->listTypeData)){
            $data = [
                'page_id' => $page->id,
                'name' => $valid->return('name'),
                'type' => $valid->return('type'),
                'data' => $valid->return('type') != 3 ? json_encode($valid->return('value')) : $valid->return('value'),
            ];
            data_page_generator::insert($data);
            redirect(referal_url(2));
        }else{
            dd($valid);
            redirect(referal_url());
        }
    }

    public function pgDataEdit()
    {
        $dataPg = data_page_generator::find(request('get')->data_id);
        $page = page_generator::find($dataPg->id);
        $this->bc(lang('admin', 'pageGenerator'), '/admin/pg/');
        $this->bc($page->name, '/' . ADMIN . '/pg/data/' . $page->id);
        $this->bc(lang('admin', 'addData'));
        $this->data['dataPg'] = $dataPg;
        $this->data['page'] = $page;
        $this->data['listTypeData'] = $this->listTypeData;
        new view('admin/pageGenerator/data/update', $this->data);
    }

    public function pgDataEditSave()
    {
        $dataPg = data_page_generator::find(request('get')->data_id);
        $page = page_generator::find($dataPg->id);

        $valid = new validate();
        $valid->name('csrf')->csrf('pgData');
        $valid->name('name')->text();
        $valid->name('type')->empty();
        $valid->name('value')->empty();
        if($page && $valid->control() && array_key_exists($valid->return('type'), $this->listTypeData)){
            $dataPg->name = $valid->return('name');
            $dataPg->type = $valid->return('type');
            $dataPg->data = $valid->return('type') != 3 ? json_encode($valid->return('value')) : $valid->return('value');
            $dataPg->save();
            redirect(referal_url(2));
        }else{
            dd($valid);
            redirect(referal_url());
        }
    }

    public function pgDataDelete()
    {
        $dataPg = data_page_generator::find(request('get')->data_id);
        $page = page_generator::find($dataPg->id);
        $this->bc(lang('admin', 'pageGenerator'), '/admin/pg/');
        $this->bc($page->name, '/' . ADMIN . '/pg/data/' . $page->id);
        $this->bc(lang('admin', 'addData'));
        $this->data['dataPg'] = $dataPg;
        $this->data['page'] = $page;
        $this->data['listTypeData'] = $this->listTypeData;
        new view('admin/pageGenerator/data/delete', $this->data);
    }

    public function pgDataDeleteAction()
    {
        $dataPg = data_page_generator::find(request('get')->data_id);
        $page = page_generator::find($dataPg->id);
        $dataPg->delete();
        redirect(referal_url(2));
    }

    public function create()
    {
        $this->title(lang('admin', 'createPage'));
        $this->bc(lang('admin', 'pageGenerator'), '/' . ADMIN .'/pg/');
        $this->bc(lang('admin', 'createPage'));
        new view('admin/pageGenerator/create', $this->data);
    }

    public function createAction()
    {
        $valid = new validate();
        $valid->name('csrf')->csrf('pageCreate');
        $valid->name('url')->url();
        $valid->name('view')->url();
        $valid->name('title')->text();
        $valid->name('description')->text();
        $valid->name('name')->text();
        $valid->name('active')->bool();

        if ($valid->control()) {
            try {
                $data = [
                    'url' => $valid->return('url'),
                    'view' => $valid->return('view'),
                    'title' => $valid->return('title'),
                    'description' => $valid->return('description'),
                    'name' => $valid->return('name'),
                    'active' => $valid->return('active'),
                ];
                page_generator::insert($data);
                alert2('success', 'success');
                redirect(referal_url(2));
            } catch (\Exception $e) {
                dd($e);
                alert2('error', 'danger');
                redirect(referal_url(), $valid->data(), $valid->error());
            }
        }
        alert2('error', 'danger');
        redirect(referal_url(), $valid->data(), $valid->error());
    }

    public function update()
    {
        $page = page_generator::find(request('get')->page_id);
        $this->title(lang('admin', 'editPage'));
        $this->bc(lang('admin', 'pageGenerator'), '/' . ADMIN .'/pg/');
        $this->bc(lang('admin', 'editPage'));
        $this->data['page'] = $page;
        new view('admin/pageGenerator/update', $this->data);
    }

    public function updateAction()
    {
        $page = page_generator::find(request('get')->page_id);
        $valid = new validate();
        $valid->name('csrf')->csrf('pageUpdate');
        $valid->name('url')->url();
        $valid->name('view')->url();
        $valid->name('title')->text();
        $valid->name('description')->text();
        $valid->name('name')->text();
        $valid->name('active')->bool();

        if ($valid->control() && $page) {
            try {
                $data = [
                    'url' => $valid->return('url'),
                    'view' => $valid->return('view'),
                    'title' => $valid->return('title'),
                    'description' => $valid->return('description'),
                    'name' => $valid->return('name'),
                    'active' => $valid->return('active'),
                ];
                $page->update($data);
                alert2('success', 'success');
                redirect(referal_url(2));
            } catch (\Exception $e) {
                dd($e);
                alert2('error', 'danger');
                redirect(referal_url(), $valid->data(), $valid->error());
            }
        }
        alert2('error', 'danger');
        redirect(referal_url(), $valid->data(), $valid->error());
    }

    public function delete()
    {
        $page = page_generator::find(request('get')->page_id);
        $this->title(lang('admin', 'deletePage'));
        $this->bc(lang('admin', 'pageGenerator'), '/' . ADMIN .'/pg/');
        $this->bc(lang('admin', 'deletePage'));   
        $this->data['page'] = $page;     
        new view('admin/pageGenerator/delete', $this->data);
    }

    public function deleteAction()
    {
        $page = page_generator::find(request('get')->page_id);
        data_page_generator::where('page_id', $page->id)->delete();
        $page->delete();
        alert2('success', 'success');
        redirect(referal_url(2));
    }
}
