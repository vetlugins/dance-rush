<?php defined('SYSPATH') or die('No direct script access.');

class Controller_News extends Controller_Common {

    protected $url_site;
    protected $lang;
    protected $config;

    public function before(){

        parent::before();

        $this->config = Kohana::$config->load('news');

        $page = 'news';
        $lang = Request::$lang;

        $data = ORM::factory('Page')
            ->where('url', '=', $page)
            ->where('lang', '=', $lang)
            ->find();

        $styles = array('plugins/nivo/nivo-slider.css','plugins/nivo/nivo-slider-default.css');

        $this->styles = array_merge($this->styles,$styles);

        $scripts = array('plugins/jquery.nivo.slider.js');

        $this->scripts = array_merge($this->scripts,$scripts);

        $this->script_page = $data->url.'.js';
        $this->style_page  = $data->url.'.css';

        View::bind_global('data', $data);

        if($lang == Kohana::$config->load('lang.default') and Kohana::$config->load('lang.hide_default') == 1) $luri = '';
        else $luri = $lang;

        $this->url_site = URL::site($luri.'/');
        $this->lang = $lang;

        $popular = ORM::factory('News_Items')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by('views','DESC')->limit(4)->find_all();
        $random = ORM::factory('News_Items')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by(DB::expr('RAND()'))->limit(4)->find_all();
        $comments = ORM::factory('News_Comment')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by('id','DESC')->limit(4)->find_all();

        $social_group = ORM::factory('Social_Group')->order_by('id','DESC')->find_all();

        View::bind_global('popular', $popular);
        View::bind_global('random', $random);
        View::bind_global('comments', $comments);
        View::bind_global('social_group', $social_group);

        $sidebar = View::factory( Kohana::$config->load('site.theme').'/news/sidebar');
        View::bind_global('sidebar', $sidebar);

        View::bind_global('config', $this->config);
    }

    public function action_index()
    {
        $page = $this->request->param('page');


        $total_items = ORM::factory('News_Items')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->count_all();

        $pagination = '';

        if($total_items > 0)
        {
            if(empty($page))
            {
                $posts = ORM::factory('News_Items')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by('id',$this->config->get('sort'))->limit($this->config->get('num'))->find_all();
            }
            else
            {
                $offset = $this->config->get('num') * ($page - 1);

                $posts = ORM::factory('News_Items')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by('id',$this->config->get('sort'))->limit($this->config->get('num'))->offset($offset)->find_all();
            }

            $post = View::factory(Kohana::$config->load('site.theme').'/news/posts')->bind('posts',$posts);

            //$pagination = Pagination::factory(array('total_items' => $total_items,'items_per_page' => $config->get('num')));
        }else{
            $status = 'items_not_found';
            $post = View::factory( Kohana::$config->load('site.theme').'/pages/error')->bind('status', $status);
        }

        $content = View::factory( Kohana::$config->load('site.theme').'/news/main')->bind('posts',$post)->bind('pagination',$pagination);

        $this->template->content = $content;
    }

}