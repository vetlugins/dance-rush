<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Statistics extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'statistics';
        $this->params['model'] = 'Statistics';

        $this->page = array(
            'icon'=>'fa-signal',
            'title' => __('Статистика посещаемости'),
            'description' => __('статистика предоставлена сервисом Яндекс.Метрика')
        );

        $this->template->plugin_specific = array(

        );

        $this->template->styles_specific = array(

        );
    }

    public function action_index()
    {
        $this->page['breadcrumb'] = array(
            array('current' => __('Главная'))
        );

        $metrica = Metrica::factory(['date1' => '10dasAgo']);
        $visits = $metrica->visits(0,true);
        $views  = $metrica->visits(1,true);
        $users  = $metrica->visits(2,true);

        $metrics = [
            'visits' => $visits,
            'views' => $views,
            'users' => $users
        ];

        $content = View::factory('/admin/'.$this->params['module'].'/show')->bind('metrics',$metrics);

        $this->template->content = $content;
    }


}
