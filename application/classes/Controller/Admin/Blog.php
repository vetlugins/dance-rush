<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Blog extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'blog';

        $this->page = array(
            'icon'=>'fa-book',
            'title' => __('Блог сайта'),
            'description' => __('управление блогом вашего сайта')
        );
        $this->template->plugin_specific = array(
            'datepicker/datetimepicker',
            'fancybox/jquery.fancybox',
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrap-file-input/bootstrap-file-input',
            'dropzone/dropzone.min',
            'bootstrapValidator/bootstrapValidator.min',
            'ckeditor/ckeditor',
            'liTranslit/jquery.liTranslit'
        );
        $this->template->styles_specific = array(
            'datepicker/datetimepicker',
            'fancybox/jquery.fancybox',
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'dropzone/dropzone',
            'bootstrapValidator/bootstrapValidator.min',
        );

    }

    public function action_category()
    {
        $this->params['model'] = 'Blog_Category';

        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array('current' => __('Категории блога'))
        );

        $items = array();

        foreach($this->languages as $lang){

            $get_items = $model->categories($lang->i18n);

            $list = '';

            foreach($get_items as $item){

                $list .= View::factory('/admin/'.$this->params['module'].'/category_list')
                    ->bind('item', $item);

                $items[$lang->i18n] = $list;

            }
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/category')
            ->bind('items',$items);
    }

    public function action_article()
    {
        $this->params['model'] = 'Blog_Article';
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array('current' => __('Статьи блога'))
        );

        $items = array();

        foreach($this->languages as $lang){

            $get_items = $model->where_soft()->lang($lang->i18n)->find_all();

            $list = '';

            foreach($get_items as $item){

                $list .= View::factory('/admin/'.$this->params['module'].'/article_list')
                    ->bind('item', $item);

                $items[$lang->i18n] = $list;

            }
        }



        $this->template->content = View::factory('/admin/'.$this->params['module'].'/article')
            ->bind('items',$items);
    }

    public function action_add()
    {
        if(!empty($_GET['model'])){

            $this->params['model'] = $_GET['model'];

            if($_GET['model'] == 'Blog_Category') {

                $this->page['breadcrumb'] = array(
                    array($this->params['url_site_admin'] => __('Главная')),
                    array($this->params['url_site_admin'] . '/' . $this->params['module'].'/category' => __('Категории блога')),
                    array('current' => __('Добавление категории'))
                );

                $section = 'category';
                $category_option = '';
            }

            if($_GET['model'] == 'Blog_Article'){

                $this->page['breadcrumb'] = array(
                    array($this->params['url_site_admin'] => __('Главная')),
                    array($this->params['url_site_admin'] . '/' . $this->params['module'].'/category' => __('Статьи блога')),
                    array('current' => __('Добавление статьи'))
                );

                $section = 'article';

                $category_option = ORM::factory('Blog_Category')->get_category_option();
            }

            if(Session::instance()->get('alert')){
                $alert = Session::instance()->get_once('alert');
                $array = Session::instance()->get_once('item');

                $item = new stdClass();
                foreach ($array as $key => $value)
                {
                    $item->$key = $value;
                }
            }
            else {
                $alert = '';
            }

            $this->template->content = View::factory('/admin/'.$this->params['module'].'/'.$section.'_edit')
                ->bind('alert',$alert)
                ->bind('item',$item)
                ->bind('category_option',$category_option);

        }else{
            if(isset($_SERVER['HTTP_REFERER'])) HTTP::redirect($_SERVER['HTTP_REFERER'] );
            else HTTP::redirect('/admin');
        }
    }

    public function action_store()
    {
        if($_POST){

            if($_POST['model'] == 'Blog_Category') $section = 'category';
            elseif($_POST['model'] == 'Blog_Article') $section = 'article';
            else HTTP::redirect('/admin');

            $this->params['model'] = $_POST['model'];
            $model = ORM::factory($this->params['model']);

            $alert = '';
            $errors = array();

            $_POST['url'] = Helper::translate($_POST['title']);

            $value = Validation::factory($_POST)
                ->rule('title', 'not_empty')
                ->rule('url', 'not_empty')
                ->rule('url', 'Model_'.$this->params['model'].'::check_url',array(':value',':validation', ':field',$this->request->post('lang')));

            $image = Validation::factory($_FILES)
                ->rule('image', 'not_empty')
                ->rule('image', 'Upload::valid')
                ->rule('image', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG')));

            if(!$value->check())
            {
                $errors = $value->errors('validation');
            }

            if(!$image->check()){
                $errors = $value->errors('validation');
            }

            if(!count($errors)){

                if(isset($_POST['view'])) $_POST['view'] = 1;
                if(isset($_POST['fixed'])) $_POST['fixed'] = 1;
                if(isset($_POST['comment'])) $_POST['comment'] = 1;

                if(isset($_POST['date'])) $_POST['created_at'] = $_POST['date'];

                $_POST['url'] = Helper::translate($_POST['title']);

                $model->change_key('id');

                $item = $model->values($_POST)->save();

                if($item->saved()){

                    if(!empty($_FILES['image']['name'])){

                        $folders = array('slider','medium','small');
                        $setting = array(
                            'cut' => array(
                                'slider' => array('width' => 725,'height' => 420),
                                'medium' => array('width' => 500,'height' => 290),
                                'small'  => array('width' => 150,'height' => 150)
                            ),
                            'coverable' => 1
                        );

                        Helper::setCover($this->params['module'],$item->id,$_FILES,$folders,$setting);
                    }

                    $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно создана').'</p></div>';

                    Session::instance()->set('alert',$alert);

                    HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$section.'/'.$item->id.'?model='.$_POST['model']);
                }else{
                    $alert = __('Не удалось создать запись');

                    Session::instance()->set('alert',$alert)->set('item',$_POST);

                    HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$section.'/add?model='.$_POST['model']);
                }
            }else{

                foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

                Session::instance()->set('alert',$alert)->set('item',$_POST);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$section.'/add?model='.$_POST['model']);
            }

        }else{
            if(isset($_SERVER['HTTP_REFERER'])) HTTP::redirect($_SERVER['HTTP_REFERER'] );
            else HTTP::redirect('/admin');
        }
    }

    public function action_edit()
    {
        if($_GET){

            $this->params['model'] = $_GET['model'];
            $model = ORM::factory($this->params['model']);

            $id = $this->request->param('id');
            $item = '';

            if($id){

                $item = $model->where('id','=', $id)->where_soft()->find();

                if(Session::instance()->get('alert')){
                    $alert = Session::instance()->get_once('alert');
                }
                else {
                    $alert = '';
                }

            }else{
                $alert = '<div class="alert alert-danger"><p>'.Kohana::message('validation', 'not_id').'</p></div>';
            }

            if($_GET['model'] == 'Blog_Category'){

                $this->page['breadcrumb'] = array(
                    array($this->params['url_site_admin'] => __('Главная')),
                    array($this->params['url_site_admin'] . '/' . $this->params['module'].'/category' => __('Категории блога')),
                    array('current' => __('Редактирование категории'))
                );

                $section = 'category';
                $category_option = '';
            }
            if($_GET['model'] == 'Blog_Article'){

                $this->page['breadcrumb'] = array(
                    array($this->params['url_site_admin'] => __('Главная')),
                    array($this->params['url_site_admin'] . '/' . $this->params['module'].'/category' => __('Статьи блога')),
                    array('current' => __('Редактирование статьи'))
                );

                $section = 'article';
                $category_option = ORM::factory('Blog_Category')->get_category_option(array(),'ru',$item->category_url);
            }

            $this->template->content = View::factory('/admin/'.$this->params['module'].'/'.$section.'_edit')
                ->bind('item',$item)
                ->bind('alert',$alert)
                ->bind('id',$id)
                ->bind('category_option',$category_option);

        }else{
            HTTP::redirect('/admin');
        }
    }

    public function action_update()
    {
        if($_POST['model'] == 'Blog_Category') $section = 'category';
        elseif($_POST['model'] == 'Blog_Article') $section = 'article';

        $this->params['model'] = $_POST['model'];
        $model = ORM::factory($this->params['model']);

        $model->change_key('id');

        $item = $model->where('id','=', $_POST['id'])->find();

        $alert = '';
        $errors = array();

        $_POST = Arr::map('trim', $_POST);

        $_POST['url'] = Helper::translate($_POST['title']);

        $value = Validation::factory($_POST)
            ->rule('title', 'not_empty')
            ->rule('url', 'not_empty');

        if(!$value->check())
        {
            $errors[] = $value->errors('validation');

        }else{
            if($item->url != $_POST['url']){

                $check_url = Validation::factory($_POST)
                    ->rule('url', 'Model_'.$this->params['model'].'::check_url',array(':value',':validation', ':field',$this->request->post('lang')));

                if(!$check_url->check())
                {
                    $errors[] = $check_url->errors('validation');
                }
            }
        }

        if(!empty($_FILES['image']['name'])){
            $image = Validation::factory($_FILES)
                ->rule('image', 'Upload::valid')
                ->rule('image', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG')));

            if(!$image->check()){
                $errors[] = $value->errors('validation');
            }
        }

        if(!count($errors)){

            if(isset($_POST['view'])) $_POST['view'] = 1; else $_POST['view']  = 0;
            if(isset($_POST['fixed'])) $_POST['fixed'] = 1; else $_POST['fixed']  = 0;
            if(isset($_POST['comment'])) $_POST['comment'] = 1; else $_POST['comment']  = 0;

            if(isset($_POST['date'])) $_POST['created_at'] = $_POST['date'];

            if($_POST['model'] == 'Blog_Article'){
                if(!empty($_FILES['image']['name'])){
                    $folders = array('slider','medium','small');
                    $setting = [
                        'cut' => [
                            'slider' => ['width' => 725,'height' => 420],
                            'medium' => ['width' => 500,'height' => 290],
                            'small'  => ['width' => 150,'height' => 150]
                        ],
                        'coverable' => 1,
                        'item' => $item->cover()
                    ];

                    Helper::setCover($this->params['module'],$item->id,$_FILES,$folders,$setting);
                }
            }

            $item->values($_POST)->save();

            $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно изменена').'</p></div>';

            Session::instance()->set('alert',$alert);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$section.'/'.$item->id.'?model='.$_POST['model']);

        }else{

            foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

            Session::instance()->set('alert',$alert)->set('item',$_POST);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$section.'/'.$item->id.'?model='.$_POST['model']);
        }

    }

    /*
    public function action_comments()
    {
        $this->params['model'] = 'Comments';

        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = [
            [$this->params['url_site_admin'] => Kohana::message('admin', 'home')],
            ['current' => Kohana::message('admin', 'titles.'.$this->params['module'].'.title.comments')]
        ];

        $items = '';

        $get_items = $model->type('Blog')->where_soft()->order_by('id','DESC')->find_all();

        foreach($get_items as $item){

            $items .= View::factory('/admin/'.$this->params['module'].'/comments_list')
                ->bind('item', $item);

        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/comments')
            ->bind('items',$items);
    }

    public function action_setting()
    {
        $this->params['model'] = 'Blog_Category';
        $this->page['breadcrumb'] = [
            [$this->params['url_site_admin'] => Kohana::message('admin', 'home')],
            ['current' => Kohana::message('admin', 'titles.'.$this->params['module'].'.title.setting')]
        ];

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/setting');
    }*/
}

