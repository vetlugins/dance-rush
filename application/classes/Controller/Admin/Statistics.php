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

        $date = date("Y-m-d",time()-2629744);

        $metrics_visits = Metrica::factory(['date1' => $date]);
        $visits = $metrics_visits->visits(0,true);
        $views  = $metrics_visits->visits(1,true);
        $users  = $metrics_visits->visits(2,true);

        $metrics_pages =  Metrica::factory(['date1' => $date,'metrics' => 'ym:pv:pageviews,ym:pv:users','preset' => 'popular','dimensions' => 'ym:pv:URLHash']);

        $metrics = [
            'visits' => $visits,
            'views' => $views,
            'users' => $users,
            'pages' => $metrics_pages->pages()
        ];

        $content = View::factory('/admin/'.$this->params['module'].'/show')->bind('metrics',$metrics);

        $this->template->content = $content;
    }


}
