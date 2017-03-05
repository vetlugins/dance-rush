<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Home extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'home';
        $this->params['model'] = 'Home';

        $this->page = array(
            'icon'=>'fa-home',
            'title' => Kohana::message('admin', 'titles.'.$this->params['module'].'.title'),
            'description' => Kohana::message('admin', 'titles.'.$this->params['module'].'.description')
        );

        $this->template->plugin_specific = array(
            'jquery-jvectormap/jquery-jvectormap-1.2.2.min',
            'jquery-jvectormap/jquery-jvectormap-europe-merc-en',
            'jquery-countTo/jquery.countTo',
            'bootstrap-tagsinput/bootstrap-tagsinput.min',
            'ion-tabs/ion.tabs.min',
            'iCheck/icheck.min',
            'fancybox/jquery.fancybox',
            'fancybox/helpers/jquery.fancybox-media',
            'countdown/countdown',
            'weather/gulpfile',
            'weather/jquery.simpleWeather.min',
            'form/jquery.form'
        );

        $this->template->styles_specific = array(
            'bootstrap-tagsinput/bootstrap-tagsinput',
            'gritter/jquery.gritter',
            'jquery-jvectormap/jquery-jvectormap-1.2.2',
            'iCheck/all',
            'ion.tabs/ion.tabs',
            'ion.tabs/ion.tabs.skinBordered',
            'fancybox/jquery.fancybox',
            'weather/weather',
        );
    }

    public function action_index()
    {
        $this->page['breadcrumb'] = array(array('current' => Kohana::message('admin', 'home')));

        $metrica = Metrica::factory(['date1' => '3dasAgo']);
        $visits = $metrica->visits(0,true);
        $views  = $metrica->visits(1,true);
        $users  = $metrica->visits(2,true);

        $metrics = [
            'visits' => $visits,
            'views' => $views,
            'users' => $users
        ];

        $content = View::factory('/admin/'.$this->params['module'].'/show')
            ->bind('metrics',$metrics);

        $this->template->content = $content;
    }


}
