<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Page extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'pages';
        $this->params['model'] = 'Page';

        $this->page = array(
            'icon'=>'fa-sitemap',
            'title' => __('Страницы сайта'),
            'description' => __('управление основными и вспомогательными страницами сайта')
        );

        $this->template->plugin_specific = array(
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrapValidator/bootstrapValidator.min',
            'ckeditor/ckeditor',
            'liTranslit/jquery.liTranslit'
        );
        $this->template->styles_specific = array(
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'bootstrapValidator/bootstrapValidator.min',
        );
    }

    public function action_index()
    {
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array('current' =>__('Страницы сайта'))
        );

        $items = array();

        foreach($this->languages as $lang){

            $all_pages = $model->pages($lang->i18n,0);

            $list = '';
            $get_parents = '';

            foreach($all_pages as $page){

                $parents = $model->pages($page->lang,$page->id);

                if(count($parents) > 0){
                    $get_parents = $this->get_parent($parents);
                }

                $list .= View::factory('/admin/'.$this->params['module'].'/list')
                    ->bind('page', $page)
                    ->bind('parents', $parents)
                    ->bind('get_parents', $get_parents);

                $items[$lang->i18n] = $list;

            }
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/all')
            ->bind('items',$items);
    }

    public function action_add()
    {
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array($this->params['url_site_admin'].'/'.$this->params['module'] => __('Страницы сайта')),
            array('current' => __('Добавление страницы'))
        );

        if(Session::instance()->get('alert')){
            $alert = Session::instance()->get_once('alert');
            $array = Session::instance()->get_once('item');

            $item = new stdClass();
            foreach ($array as $key => $value)
            {
                $item->$key = $value;
            }

            $pages_option = ORM::factory($this->params['model'])->get_page_option(array(),$item->lang,$item->parent_id);
        }
        else {
            $alert = '';
            $pages_option = $model->get_page_option();
        }

        $roles = ORM::factory('Auth_Role')->order_by('id','DESC')->find_all();

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/edit')
            ->bind('pages_option',$pages_option)
            ->bind('item',$item)
            ->bind('alert',$alert)
            ->bind('roles',$roles);
    }

    public function action_store()
    {
        $model = ORM::factory($this->params['model']);

        $alert = '';
        $errors = array();

        $_POST = Arr::map('trim', $_POST);

        $value = Validation::factory($_POST)
            ->rule('title', 'not_empty')
            ->rule('url', 'not_empty')
            ->rule('url', 'Model_'.$this->params['model'].'::check_url',array(':value',':validation', ':field',$this->request->post('lang')));

        if(!$value->check())
        {
            $errors = $value->errors('validation');
        }

        if(!count($errors)){

            if(isset($_POST['view'])) $_POST['view'] = 1;
            else $_POST['view']  = 0;

            $item = $model->values($_POST)->save();

            $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно создана').'</p></div>';

            Session::instance()->set('alert',$alert);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->id);

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
            array($this->params['url_site_admin'].'/'.$this->params['module'] => __('Страницы сайта')),
            array('current' => __('Редактирование страницы'))
        );

        $id = $this->request->param('id');

        if(Session::instance()->get('alert'))$alert = Session::instance()->get_once('alert');
        else $alert = '';

        if($id){

            $item = $model->page($id);

            $pages_option = ORM::factory($this->params['model'])->get_page_option(array(),$item->lang,$item->parent_id);

            $roles = ORM::factory('Auth_Role')->order_by('id','DESC')->find_all();

        }else{
            $alert = '<div class="alert alert-danger"><p>'.__('Нет элементов для отображения').'</p></div>';
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/edit')
            ->bind('id',$id)
            ->bind('item',$item)
            ->bind('pages_option',$pages_option)
            ->bind('alert',$alert)
            ->bind('roles',$roles);
    }

    public function action_update()
    {
        $model = ORM::factory($this->params['model']);

        $item = $model->page($_POST['id']);

        $alert = '';
        $errors = array();

        $_POST = Arr::map('trim', $_POST);

        $value = Validation::factory($_POST)
            ->rule('title', 'not_empty')
            ->rule('url', 'not_empty');

        if(!$value->check())
        {
            $errors = $value->errors('validation');

        }else{
            if($item->url != $_POST['url']){

                $check_url = Validation::factory($_POST)
                    ->rule('url', 'Model_'.$this->params['model'].'::check_url',array(':value',':validation', ':field',$this->request->post('lang')));

                if(!$check_url->check())
                {
                    $errors = $check_url->errors('validation');
                }
            }
        }

        if(!count($errors)){

            if(isset($_POST['view'])) $_POST['view'] = 1;
            else $_POST['view']  = 0;

            $item->values($_POST)->save();

            $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно изменена').'</p></div>';

            Session::instance()->set('alert',$alert);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->id);

        }else{

            foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

            Session::instance()->set('alert',$alert)->set('item',$_POST);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->id);
        }

    }

    public function get_parent($pages){

        $model = ORM::factory($this->params['model']);

        $list = '';

        foreach($pages as $parent){

            $parents = $model->pages($parent->lang,$parent->id);

            if(count($parents) > 0){
                $get_parents = $this->get_parent($parents);
            }

            $list .= View::factory('/admin/'.$this->params['module'].'/list')
                ->bind('page', $parent)
                ->bind('parents', $parents)
                ->bind('get_parents', $get_parents);
        }

        return $list;
    }


}

