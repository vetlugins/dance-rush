<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Params extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'params';
        $this->params['model'] = 'Params_Items';

        $this->page = array(
            'icon'=>'fa-gears',
            'title' => __('Список параметров сайта'),
            'description' => __('управление настройками сайта')
        );

        $this->template->plugin_specific = array(
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrapValidator/bootstrapValidator.min',
            'fancybox/jquery.fancybox',
            'bootstrap-file-input/bootstrap-file-input',
        );
        $this->template->styles_specific = array(
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'fancybox/jquery.fancybox',
            'bootstrapValidator/bootstrapValidator.min',
        );

    }

    public function action_index()
    {
        $model = ORM::factory($this->params['model'])->order_by('name');

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array('current' => __('Параметры'))
        );

        $sections = ORM::factory('Params_Section')->find_all();

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/all')
            ->bind('settings',$model)
            ->bind('sections',$sections);
    }

    public function action_add()
    {
        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array($this->params['url_site_admin'].'/'.$this->params['module'] => __('Параметры')),
            array('current' => __('Добавление параметра'))
        );

        if(Session::instance()->get('alert')){
            $alert = Session::instance()->get_once('alert');
            $array = Session::instance()->get_once('item');

            $item = new stdClass();
            foreach ($array as $key => $value)
            {
                $item->$key = $value;
            }

        }
        else {
            $alert = '';
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/edit')
            ->bind('item',$item)
            ->bind('alert',$alert);
    }

    public function action_store()
    {
        $model = ORM::factory($this->params['model']);

        $alert = '';
        $errors = array();

        $_POST = Arr::map('trim', $_POST);

        if($_POST['type'] == 'text'){
            $value = Validation::factory($_POST)
                ->rule('value-text', 'not_empty')
                ->rule('title', 'not_empty')
                ->rule('name', 'not_empty')
                ->rule('name', 'Model_'.$this->params['model'].'::check_name',array(':value',':validation', ':field'));
        }else{
            $value = Validation::factory($_POST)
                ->rule('title', 'not_empty')
                ->rule('name', 'not_empty')
                ->rule('name', 'Model_'.$this->params['model'].'::check_name',array(':value',':validation', ':field'));
        }

        if(!$value->check())
        {
            $errors = $value->errors('validation');
        }

        if(!count($errors)){

            if($_POST['type'] == 'text') {
                $_POST['value'] = $_POST['value-text'];
            }

            if($_POST['type'] == 'checkbox') {
                if(isset($_POST['value-checkbox'])) $_POST['value'] = 1; else $_POST['value'] = 0;
            }

            if($_POST['type'] == 'image') {

            }

            $item = $model->values($_POST);

            if($item->save()){

                $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно создана').'</p></div>';

                Session::instance()->set('alert',$alert);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->section.'/'.$item->name);

            }else{

                $alert .= '<div class="alert alert-danger"><p>'.__('Не удалось создать запись').'</p></div>';

                Session::instance()->set('alert',$alert)->set('item',$_POST);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/add');
            }

        }else{

            foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

            Session::instance()->set('alert',$alert)->set('item',$_POST);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/add');
        }

    }

    public function action_edit()
    {
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array($this->params['url_site_admin'].'/'.$this->params['module'] => __('Параметры')),
            array('current' => __('Редактирование параметра'))
        );

        $id = $this->request->param('id');
        $name = $this->request->param('name');

        if(Session::instance()->get('alert')) $alert = Session::instance()->get_once('alert');
        else $alert = '';

        if($id and $name){

            $item = $model->where('section','=',$id)->and_where('name','=',$name)->find();

        }else{
            $alert = '<div class="alert alert-danger"><p>'.__('Нет элементов для отображения').'</p></div>';
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/edit')
            ->bind('id',$id)
            ->bind('name',$name)
            ->bind('item',$item)
            ->bind('alert',$alert);
    }

    public function action_update()
    {
        $model = ORM::factory($this->params['model']);

        $item = $model->where('name','=',$_POST['name'])->find();

        if($item->loaded()){

            $alert = '';
            $errors = array();

            $_POST = Arr::map('trim', $_POST);

            if($_POST['type'] == 'text'){
                $value = Validation::factory($_POST)
                    ->rule('value', 'not_empty')
                    ->rule('title', 'not_empty');
            }else{
                $value = Validation::factory($_POST)
                    ->rule('title', 'not_empty');
            }

            if(!$value->check())
            {
                $errors = $value->errors('validation');

            }

            if(!count($errors)){

                if($_POST['type'] == 'checkbox') {
                    if(isset($_POST['value'])) $_POST['value'] = 1; else $_POST['value'] = 0;
                }

                $item->values($_POST)->save();

                $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно изменена').'</p></div>';

                Session::instance()->set('alert',$alert);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->section.'/'.$item->name);

            }else{

                foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

                Session::instance()->set('alert',$alert)->set('item',$_POST);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->section.'/'.$item->name);
            }

        }else{
            echo __('Произошла какая то не понятная ошибка'); die;
        }

    }

}

