<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Page extends Controller_Common {

    public function action_index()
    {
        $page = $this->request->param('uri');
        $lang = Request::$lang;

        if(empty($page)) $page = 'index';

        $data = ORM::factory('Page')->where('url', '=', $page)->where('lang', '=', $lang)->find();

        if(!$data->loaded()){

            $status = '404';
            $content = View::factory( Kohana::$config->load('site.theme').'/error')->bind('status', $status);

        }else{

            switch($data->url){
                case 'index':

                    $reviews = ORM::factory('Reviews')->where_soft()->order_by('id','DESC')->find_all();

                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/main')
                        ->bind('articles',$articles)
                        ->bind('reviews',$reviews);
                    break;
                case 'about':
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/about');
                    break;
                case 'services':
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/services');
                    break;
                case 'contacts':
                    $content = View::factory( Kohana::$config->load('site.theme').'/pages/contacts');
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