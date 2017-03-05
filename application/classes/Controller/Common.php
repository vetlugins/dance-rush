<?php defined('SYSPATH') or die('No direct script access.');
 
abstract class Controller_Common extends Controller_Template {
 
    public $template = 'default/home';
    public $params   = array();

    public function before()
    {
        parent::before();

         /* Языки сайта*/
		$lang = $this->lang($this->request->param('lang'));

        /*Основные настройки сайта*/
        $this->params = $this->params($lang);

		/*Смена шаблона сайта*/
		$this->template = new View(Params::obtain('theme').'/home');

        /* Страницы сайта */
        $pages = $this->pages('all');

        /* Шарим */
        View::bind_global('params', $this->params);
        View::bind_global('pages',$pages);

        /* -- XML generator --*/
        if(isset($_GET['sitemap'])){
            $sitemap = new Sitemap();

            //игнорировать ссылки с расширениями:
            $sitemap->set_ignore(array("javascript:", ".css", ".js", ".ico", ".jpg", ".png", ".jpeg", ".swf", ".gif"));

            //ссылка сайта:
            $sitemap->get_links($this->params['site']['domain']);

            header ("content-type: text/xml");
            $map = $sitemap->generate_sitemap();
            echo $map;

            die;
        }
    }

    private function pages($access){

        $get_pages = ORM::factory('Page')
            ->where('access','=',$access)
            ->where('view','=',1)
            ->where_soft()
            ->lang($this->params['lang'])
            ->parent(0)
            ->order_by('sort', 'ASC')
            ->find_all();

        $pages = '';

        foreach($get_pages as $page){

            $current_page = $this->request->param('uri') ? $this->request->param('uri'):'index';

            if($current_page == $page->url){
                $current = '  ';
                $sr_only = ' <span class="sr-only"><b class="caret"></b></span> ';
            }else {
                $current = '';
                $sr_only = '';
            }

            if(!empty($page->redirect))$url = $page->redirect;
            elseif($page->url == 'index') $url = $this->params['url_site'];
            else $url = $this->params['url_site'].$page->url;

            $parents = ORM::factory('Page')
                ->where('access','=',$access)
                ->where_soft()
                ->lang($this->params['lang'])
                ->parent($page->id)
                ->find_all();

            if($parents->count()){
                $pages .= '<li class="nav-item '.$current.' dropdown">
                            <a href="'.$url.'" class="nav-link dropdown-toggle" target="_'.$page->target.'"  id="'.$page->id.'" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                '.$page->title.' '.$sr_only.'
                            </a>
                            '.$this->pages_parent($page->id).'
                        </li>';
            }else{
                $pages .= '<li class="nav-item '.$current.'">
                                <a href="'.$url.'" class="nav-link" target="_'.$page->target.'">
                                    '.$page->title.' '.$sr_only.'
                                </a>
                            </li>';
            }
        }

        return $pages;
    }

    private function pages_parent($id){

        $pages  = ORM::factory('Page')->pages($this->params['lang'],$id);

        $view = '';

        if(count($pages) > 0){
            $view = '<div class="dropdown-menu" aria-labelledby="'.$id.'">';

            foreach($pages as $page){

                if(!empty($page->redirect))$url = $page->redirect;
                elseif($page->url == 'index') $url = $this->params['url_site'];
                else $url = $this->params['url_site'].$page->url;

                $view .= '<a href="'.$url.'"  class="dropdown-item" target="_'.$page->target.'">'.$page->title.'</a>';
            }

            $view .= '</div>';
        }

        return $view;
    }

    private function lang($lang){

        I18n::lang($lang);

        if($lang == Kohana::$config->load('lang.default') and Kohana::$config->load('lang.hide_default') == 1) $uri = '';
        else $uri = $lang;

        $selector = Multilang::selector($lang);

        return array('selector' => $selector, 'uri' => $uri, 'i18n' => $lang);
    }

    private function params($lang){

        return array(
            'blog'     => Kohana::$config->load('blog'),
            'url_site' => URL::site($lang['uri'].'/'),
            'url_base' => URL::base(),
            'lang'     => $lang['i18n'],
        );

    }
}