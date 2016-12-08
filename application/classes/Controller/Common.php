<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Common extends Controller_Template {
 
    public $template = 'default/home';
    public $params   = array();
    public $styles   = array();
    public $scripts  = array();
    public $script_page;
    public $style_page;
 
    public function before()
    {
        parent::before();

         /* Языки сайта*/
		$lang_uri = $this->request->param('lang');

		I18n::lang($lang_uri);

		//$mlang = Multilang::selector($lang_uri);

		if($lang_uri == Kohana::$config->load('lang.default') and Kohana::$config->load('lang.hide_default') == 1) $luri = '';
		else $luri = $lang_uri;

        /*Основные настройки сайта*/
        $this->params = array(
            'config'   => Kohana::$config->load('site'),
            'url_site' => URL::site($luri.'/'),
            'url_base' => URL::base(),
            'theme'    => URL::base().'templates/'.Kohana::$config->load('site.theme').'/',
            'lang'     => $lang_uri,
            'title'    => ' :: '. __('Dance Rush - Студия современного танца')
        );

		/*Смена шаблона сайта*/
		$this->template = new View(Kohana::$config->load('site.theme').'/home');

        //Стили по умолчанию
        $this->styles = [
            'plugins/font-awesome.css',
            'plugins/bootstrap.css',
            'style.css',
            'media.css'
        ];

        // JS скрипты
        $this->scripts = [
            'plugins/jquery.min.js',
            'plugins/bootstrap.min.js',
            'plugins/jquery.inputmask.js',
            'custom.js'
        ];

        $menus = ORM::factory('Menu')->find_all();
        $pages = array();
        foreach($menus as $menu){
            $pages[$menu->position] = $this->pages($menu->id,'all');
        }

        // Шарим
        View::bind_global('params', $this->params);
        View::bind_global('styles', $this->styles);
        View::bind_global('scripts', $this->scripts);
        View::bind_global('script_page', $this->script_page);
        View::bind_global('style_page', $this->style_page);
        View::bind_global('pages',$pages);
	}

    private function pages($menu,$access){

        $get_pages = ORM::factory('Page')
            ->where('menu_id','=',$menu)
            ->where('lang','=',$this->params['lang'])
            ->where('access','=',$access)
            ->where('view','=',1)
            ->where('parent_id','=',0)
            ->order_by('sort','ASC')->find_all();

        $pages = '';

        foreach($get_pages as $page){

            $current_page = $this->request->param('uri') ? $this->request->param('uri'):'index';

            if($current_page == $page->url){
                $current = ' active ';
                $sr_only = ' <span class="sr-only">(current)</span> ';
            }else {
                $current = '';
                $sr_only = '';
            }

            if($page->menu->icon_sub == 1) $icon_sub = $page->icon ? '<span><i class="fa fa-'.$page->icon.'"></i></span>' : '';
            elseif($page->menu->icon_sub == 2) $icon_sub = $page->sub  ? '<span class="sub">'.$page->sub.'</span>' : '';
            else $icon_sub = '';

            if(!empty($page->redirect))$url = $page->redirect;
            elseif($page->url == 'index') $url = $this->params['url_site'];
            else $url = $this->params['url_site'].$page->url;

            $pages .= '<li class="nav-item '.$current.'">
                            <a href="'.$url.'" target="_'.$page->target.'">
                                '.$icon_sub.'
                                '.$page->title.' '.$sr_only.'
                            </a>
                        </li>';

        }

        return $pages;
    }
}