<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page extends Controller_Common {

    public function action_index()
    {
        // Определяем страницу и язык сайта
        $page = $this->request->param('uri');
        $lang = Request::$lang;

        if(empty($page)) $page = 'index';

        // получаем данные страницы

        $data = ORM::factory('Page')
            ->where('url', '=', $page)
            ->where('lang', '=', $lang)
            ->find();

        if(!$data->loaded()){

            $status = Response::factory()->status(404) ;

            $content = View::factory( Kohana::$config->load('site.theme').'/pages/error')->bind('status', $status);

        }else{

            switch($data->url){
                case 'index':
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/main');

                    $styles = array(
                        'plugins/rs-plugin/css/settings.css',
                        'plugins/rs-plugin/css/extralayers.css'
                    );

                    $this->styles = array_merge($this->styles,$styles);

                    $scripts = array(
                        'plugins/rs-plugin/js/jquery.themepunch.plugins.min.js',
                        'plugins/rs-plugin/js/jquery.themepunch.revolution.min.js'
                    );

                    $this->scripts = array_merge($this->scripts,$scripts);

                    $this->script_page = 'home.js';

                    break;
                case 'about':
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/'.$data->url);

                    $styles = array();

                    $this->styles = array_merge($this->styles,$styles);

                    $scripts = array(
                        'plugins/parallax.js',
                        'plugins/modernizr.js'
                    );

                    $this->scripts = array_merge($this->scripts,$scripts);

                    $this->script_page = $data->url.'.js';
                    $this->style_page  = $data->url.'.css';

                    break;
                case 'services':
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/'.$data->url);

                    $styles = array(
                        'plugins/owl/owl.carousel.css',
                        'plugins/owl/owl.transitions.css'
                    );

                    $this->styles = array_merge($this->styles,$styles);

                    $scripts = array(
                        'plugins/owl.carousel.js'
                    );

                    $this->scripts = array_merge($this->scripts,$scripts);

                    $this->script_page = $data->url.'.js';
                    $this->style_page  = $data->url.'.css';

                    break;
                case 'contacts':
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/'.$data->url);

                    $styles = array();

                    $this->styles = array_merge($this->styles,$styles);

                    $scripts = array();

                    $this->scripts = array_merge($this->scripts,$scripts);

                    $this->script_page = $data->url.'.js';
                    $this->style_page  = $data->url.'.css';

                    break;
                default:
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/default');
                    break;
            }


        }

        View::bind_global('data', $data);

        $this->template->content = $content;
    }

}