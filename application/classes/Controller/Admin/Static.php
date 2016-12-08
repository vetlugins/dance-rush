<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Static extends Controller_Admin_Common {

    public function action_index()
    {
        $this->params['module'] = 'home';
        $this->page = array(
            'icon'=>'fa-home',
            'title' => 'Админстраторская панель',
            'description' => 'система контроля и управления сайтом',
            'breadcrumb' => '<li class="active">Главная</li>'
        );

        $content = View::factory('/admin/pages/show');

        $this->template->content = $content;
        $this->template->plugin_specific = array(
            'flot/jquery.flot.min',
            'flot/jquery.flot.resize.min',
            'flot/jquery.flot.stack.min',
            'flot/jquery.flot.crosshair.min',
            'flot/jquery.flot.time',
            'flot/jquery.flot.symbol',
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
        $this->template->script_specific = array('dashboard');
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
}
