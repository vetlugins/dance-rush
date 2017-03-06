<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Photo extends Controller_Common {

    protected $url_site;
    protected $lang;
    protected $data;

    public function before(){

        parent::before();

        $page = 'photo';
        $lang = Request::$lang;

        $this->params['url_site'] = $this->params['url_site'].$page;

        $data = ORM::factory('Page')
            ->where('url', '=', $page)
            ->where('lang', '=', $lang)
            ->find();

        $this->data = $data;
        View::bind_global('data', $this->data);


        if($lang == Kohana::$config->load('lang.default') and Kohana::$config->load('lang.hide_default') == 1) $luri = '';
        else $luri = $lang;

        $this->url_site = URL::site($luri.'/');
        $this->lang = $lang;

    }

    public function action_index()
    {
        $albums = ORM::factory('Photo_Album')->albums($this->lang,1);

        if(count($albums) > 0){

            $content = View::factory( Params::obtain('theme').'/'.$this->data->url.'/main')
                ->bind('albums',$albums);

        }else{
            $status = 'items_not_found';
            $content = View::factory( Params::obtain('theme').'/error')->bind('status',$status);
        }

        return $this->template->content = $content;
    }

    public function action_album()
    {
        $url = $this->request->param('id');

        $albums = ORM::factory('Photo_Album')->where('url','=',$url)->find();

        $albums->set('views',$albums->views+1)->update();

        $content = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/show')
            ->bind('album',$albums);

        return $this->template->content = $content;
    }

}