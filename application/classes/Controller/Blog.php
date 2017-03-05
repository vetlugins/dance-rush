<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Blog extends Controller_Common {

    protected $url_site;
    protected $lang;
    protected $data;

    public function before(){

        parent::before();

        $page = 'blog';
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

        // Категории блога
        $categories = ORM::factory('Blog_Category')->where_soft()->view(1)->lang($lang)->parent(0)->order_by('sort','ASC')->find_all();
        View::bind_global('categories', $categories);

        // Сататьи блога
        $popular = ORM::factory('Blog_Article')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by('views','DESC')->limit(4)->find_all();
        $random = ORM::factory('Blog_Article')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by(DB::expr('RAND()'))->limit(4)->find_all();

        View::bind_global('random', $random);
        View::bind_global('popular', $popular);

        // Социальные группы
        $social_group  = ORM::factory('Social_Group')->find_all();

        View::bind_global('social_group', $social_group);
    }

    public function action_index()
    {
        $count = ORM::factory('Blog_Article')->where('lang','=',$this->lang)->where_soft()->count_all();

        if($count > 0){

            $fixed = ORM::factory('Blog_Article')->where('lang','=',$this->lang)->and_where('view','=',1)->and_where('fixed','=',1)->order_by('id','DESC')->where_soft()->find_all();

            $posts = ORM::factory('Blog_Article')->where('lang','=',$this->lang)->and_where('view','=',1)->order_by('id','DESC')->where_soft()->find_all();

            $article_fixed  = count($fixed) ? View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/_snippets/_fixed')->bind('posts',$fixed) : '';
            $article_latest = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/_snippets/_posts')->bind('posts',$posts);
            $pagination     = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/_snippets/_pagination');

            $content = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/main')
                ->bind('article',$article_latest)
                ->bind('article_fixed',$article_fixed)
                ->bind('pagination',$pagination)
                ->bind('count',$count);
        }else{
            $status = 'items_not_found';
            $content = View::factory( Kohana::$config->load('site.theme').'/pages/error')->bind('status',$status);
        }

        return $this->template->content = $content;
    }

    public function action_category()
    {
        $url = $this->request->param('id');

        $category = ORM::factory('Blog_Category')->where('url','=',$url)->find();
        $posts = $category->articles->where('lang','=',$this->lang)->and_where('view','=',1)->order_by('id','DESC')->where_soft()->find_all();
        $count = $category->articles->count_all();

        $article = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/_snippets/_posts')->bind('posts',$posts);
        $pagination     = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/_snippets/_pagination')->bind('category',$category);

        $content = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/main')
            ->bind('category',$category)
            ->bind('article',$article)
            ->bind('pagination',$pagination)
            ->bind('count',$count);

        return $this->template->content = $content;
    }

    public function action_show(){

        $url = $this->request->param('id');

        if(!empty($url)){

            $article = ORM::factory('Blog_Article')->article($url,$this->lang);

            if(count($article)){

                $config = Kohana::$config->load('blog');

                $this->data->meta_title = $article->meta_title;
                $this->data->meta_description = $article->meta_description;

                $random = ORM::factory('Blog_Article')->where('lang','=',$this->lang)->where('view','=',1)->where('deleted_at','=',null)->order_by(DB::expr('RAND()'))->limit(4)->find_all();;

                $date = new DateFormat($article->created_at);
                $date = $date->get_date(Params::obtain('date_format'));

                $author = $article->author->username;

                if ($article->image_visible == 1) $image = '';
                else  $image = '<img class="card-img-top" src="/uploads/'.$this->data->url.'/original/' . $article->cover() . '" alt="' . $article->title . '">';

                $comment = false;

                if($config->get('comment') == 1){
                    if($article->comment == 1){
                        $comment = true;
                    }
                }

                $item = [
                    'date' => $date,
                    'author' => $author,
                    'image' => $image,
                    'title' => $article->title,
                    'text' => $article->text,
                    'description' => $article->description,
                    'views' => $article->views,
                    'comment' => $comment,
                    'item_id' => $article->id,
                    'item_type' => 'Blog'
                ];

                if($comment){

                    $all_comments = ORM::factory('Comments')->comments($article->id,'Blog',10);
                    $count_comments = ORM::factory('Comments')->count($article->id,'Blog');
                    $show_comments = '';

                    foreach($all_comments as $value){

                        if($value->user_id == 0){
                            $username = $value->name;
                            $city = $value->city;

                            $image = '/uploads/system/no_avatar.jpg';
                        }else{
                            $username = $value->author->username;
                            $city = $value->author->city;

                            if(is_file(DOCROOT.'uploads/users/'.$value->author->photo)) $image = '/uploads/users/'.$value->author->photo;
                            else $image = '/uploads/system/no_avatar.jpg';
                        }

                        $date = new DateFormat($value->created_at);
                        $date = $date->get_date(Params::obtain('date_format'));

                        $item_comment = [
                            'comment' => $value->comment,
                            'date' => $date,
                            'photo' => $image,
                            'name' => $username,
                            'city' => $city,
                            'id' => $value->id,
                            'rating' => $value->rating
                        ];

                        $show_comments .= View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/show_comments')->bind('comments',$item_comment);
                    }

                    $show_comments = '<li>'.$show_comments.'</li>';
                    $type_p = 'comment';

                    $pagination = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/_snippets/_pagination')
                        ->bind('pagination',$type_p)->bind('id',$item['item_id']);

                    $comments = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/comments')
                        ->bind('item',$item)
                        ->bind('show_comments',$show_comments)
                        ->bind('count',$count_comments)
                        ->bind('pagination',$pagination);
                }
                else $comments = '';

                $show = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/show')
                    ->bind('item',$item)
                    ->bind('read_more',$random)
                    ->bind('comments',$comments);

                $content = View::factory( Kohana::$config->load('site.theme').'/'.$this->data->url.'/main')
                    ->bind('article',$show)
                    ->bind('show_article',$url);
            }else{
                $status = 'items_not_found';
                $content = View::factory( Kohana::$config->load('site.theme').'/pages/error')->bind('status',$status);
            }

        }else{
            $status = 'items_not_found';
            $content = View::factory( Kohana::$config->load('site.theme').'/pages/error')->bind('status',$status);
        }

        return $this->template->content = $content;
    }
}