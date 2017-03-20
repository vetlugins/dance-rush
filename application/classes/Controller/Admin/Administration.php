<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Administration extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        if (!Auth::instance()->logged_in('superadmin'))
        {
            HTTP::redirect('/admin');
        }

        $this->params['module'] = 'administration';
        $this->params['model'] = 'Administration';

        $this->page = array(
            'icon'=>'fa-user-secret',
            'title' => __('Администрирование'),
            'description' => __('секретный раздел администраторской панели')
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
            'bootstrapValidator/bootstrapValidator.min',
            'fancybox/jquery.fancybox',
        );

    }

    public function action_index()
    {
        //$model = ORM::factory($this->params['model'])->order_by('name');

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array('current' => __('Администрирование'))
        );


        $this->template->content = View::factory('/admin/'.$this->params['module'].'/all');
    }

    public function action_add()
    {
        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array($this->params['url_site_admin'].'/'.$this->params['module'] => __('Administration')),
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
}

