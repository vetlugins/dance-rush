<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Admin_Common extends Controller_Template {

    public $template = 'admin/default';
    public $params;
    public $page;
    public $languages;

    public function before()
    {
        parent::before();

        if (!Auth::instance()->get_user())
        {
            $session = Session::instance();
            $session->set('redirectAfterLogin', $_SERVER['REQUEST_URI']);

            HTTP::redirect('/login');
        }

        if (!Auth::instance()->logged_in('admin'))
        {
            HTTP::redirect('/');
        }

        /*Основные настройки сайта*/
        $this->params = array(
            'config'   => Kohana::$config->load('site'),
            'url_site' => URL::site(),
            'url_site_admin' => URL::site('/admin'),
            'url_base' => URL::base(),
            'theme'    => '/templates/admin/'
        );

        $this->languages = ORM::factory('Lang')->find_all();

        View::bind_global('params', $this->params);
        View::bind_global('page', $this->page);
        View::bind_global('languages', $this->languages);
	}

}