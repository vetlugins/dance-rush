<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Filemanager extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'filemanager';
        $this->params['model'] = 'Filemanager';

        $this->page = array(
            'icon'=>'fa-folder-open-o',
            'title' => Kohana::message('admin', 'titles.'.$this->params['module'].'.title'),
            'description' => Kohana::message('admin', 'titles.'.$this->params['module'].'.description')
        );

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
        $this->page['breadcrumb'] = array(
            array('current' => Kohana::message('admin', 'home'))
        );

        $content = View::factory('/admin/'.$this->params['module'].'/show');

        $this->template->content = $content;
    }


}
