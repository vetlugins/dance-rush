<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_News extends Controller_Admin_Common {

    private $model;

    public function before()
    {
        parent::before();

        $this->model = ORM::factory('News_Items');

        $this->params['module'] = 'news';
        $this->page = array(
            'icon'=>'fa-book',
            'title' => 'Новостной раздел',
            'description' => 'Управление новостями вашего сайта'
        );

        $this->template->plugin_specific = array(
            'fancybox/jquery.fancybox',
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrap-file-input/bootstrap-file-input',
            'dropzone/dropzone.min',
            'bootstrapValidator/bootstrapValidator.min',
            'liTranslit/jquery.liTranslit',
            'ckeditor/ckeditor'
        );
        $this->template->styles_specific = array(
            'fancybox/jquery.fancybox',
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'dropzone/dropzone',
            'bootstrapValidator/bootstrapValidator.min',
        );
        $this->template->script_specific = array('news');
    }

    public function action_index()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => 'Главная'],['current' => 'Все новости']];

        $items = array();

        foreach($this->languages as $lang){

            $all_news = $this->model->getAllNews($lang->i18n);

            $list = '';

            foreach($all_news as $news){

                $list .= View::factory('/admin/pages/'.$this->params['module'].'/list')
                    ->bind('news', $news);

                $items[$lang->i18n] = $list;

            }
        }

        $this->template->content = View::factory('/admin/pages/'.$this->params['module'].'/all')
            ->bind('items',$items);
    }

    public function action_add()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => 'Главная'], [$this->params['url_site_admin'].'/'.$this->params['module'] => 'Все новости'], ['current' => 'Добавление новости']];

        $alert = '';

        if (isset($_POST['addNews'])){

            $_POST = Arr::map('trim', $_POST);

            $errors = false;
            $logs = array();

            $value = Validation::factory($_POST)
                ->rule('title', 'not_empty');

            if(!$value->check()) {
                $errors = true;
                $logs = $value->errors('validation');
            }

            if(isset($_FILES['image'])){
                $image = Validation::factory($_FILES)
                    ->rule('image', 'Upload::valid')
                    ->rule('image', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG')));

                if(!$image->check()){
                    $errors = true;
                    $logs = $value->errors('validation');
                }
            }

            if($errors == false){

                if(isset($_FILES))
                {
                    $ext = substr($_FILES['image']['name'],strpos($_FILES['image']['name'],'.'),strlen($_FILES['image']['name'])-1);
                    $name = 'news_'.time().$ext;
                    $dir = DOCROOT.'uploads/news/';

                    $filename = Upload::save($_FILES['image'], $name, $dir.'original/', 0777);

                    $watermark_filename = DOCROOT.'uploads/watermark/'.Kohana::$config->load('site.watermark').'.png';
                    $watermark = Image::factory($watermark_filename);

                    Image::factory($filename,'GD')
                        ->resize(500, null, Image::HEIGHT)
                        ->save($dir.'medium/'.$name);

                    Image::factory($filename,'GD')
                        ->resize(200, null, Image::HEIGHT)
                        ->save($dir.'small/'.$name);

                    Image::factory($filename)->watermark($watermark,TRUE, TRUE)->save();

                    $_POST['image'] = $name;
                }

                $_POST['url'] = VFunction::translit($_POST['title']);

                if(isset($_POST['view'])) $_POST['view'] = 1;
                else $_POST['view']  = 0;

                $this->model->values($_POST)->save();

                $alert .= '<div class="alert alert-success"><p>'.Kohana::message('success', 'admin.news.add').'</p></div>';

            }else{
                foreach($logs as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

            }
        }

        $this->template->content = View::factory('/admin/pages/'.$this->params['module'].'/add')
            ->bind('alert',$alert);
    }

    public function action_edit()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => 'Главная'], [$this->params['url_site_admin'].'/news' => 'Все новости'], ['current' => 'Редактирование статьи']];

        $id = $this->request->param('id');
        $alert = '';

        if($id){

            $item = $this->model->where('id','=', $id)->where_soft()->find();

            if (isset($_POST['editNews'])){

                $_POST = Arr::map('trim', $_POST);

                $errors = false;
                $logs = array();

                $value = Validation::factory($_POST)
                    ->rule('title', 'not_empty')
                    ->rule('description', 'not_empty')
                    ->rule('text', 'not_empty');

                if(!$value->check()) {
                    $errors = true;
                    $logs = $value->errors('validation');
                }

                if(isset($_FILES['image'])){
                    $image = Validation::factory($_FILES)
                        ->rule('image', 'Upload::valid')
                        ->rule('image', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG')));

                    if(!$image->check()){
                        $errors = true;
                        $logs = $value->errors('validation');
                    }
                }

                if($errors == false){

                    if(isset($_FILES))
                    {
                        if(is_file(DOCROOT.'/uploads/news/medium/'.$item->image)) unlink(DOCROOT.'/uploads/news/medium/'.$item->image);
                        if(is_file(DOCROOT.'/uploads/news/small/'.$item->image)) unlink(DOCROOT.'/uploads/news/small/'.$item->image);
                        if(is_file(DOCROOT.'/uploads/news/original/'.$item->image)) unlink(DOCROOT.'/uploads/news/original/'.$item->image);

                        $ext = substr($_FILES['image']['name'],strpos($_FILES['image']['name'],'.'),strlen($_FILES['image']['name'])-1);
                        $name = 'news_'.time().$ext;
                        $dir = DOCROOT.'uploads/news/';

                        $filename = Upload::save($_FILES['image'], $name, $dir.'original/', 0777);

                        $watermark_filename = DOCROOT.'uploads/watermark/'.Kohana::$config->load('site.watermark').'.png';
                        $watermark = Image::factory($watermark_filename);

                        Image::factory($filename,'GD')
                            ->resize(500, null, Image::HEIGHT)
                            ->save($dir.'medium/'.$name);

                        Image::factory($filename,'GD')
                            ->resize(200, null, Image::HEIGHT)
                            ->save($dir.'small/'.$name);

                        Image::factory($filename)->watermark($watermark,TRUE, TRUE)->save();

                        $_POST['image'] = $name;
                    }else{
                        $_POST['image'] = $item->image;
                    }

                    if(isset($_POST['view'])) $_POST['view'] = 1;
                    else $_POST['view']  = 0;

                    $item->values($_POST)->save();

                    $alert .= '<div class="alert alert-success"><p>'.Kohana::message('success', 'admin.news.edit').'</p></div>';

                }else{
                    foreach($logs as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

                }
            }

        }else{
            $alert = '<div class="alert alert-danger"><p>'.Kohana::message('validation', 'not_id').'</p></div>';
        }

        $this->template->content = View::factory('/admin/pages/news/edit')
            ->bind('item',$item)
            ->bind('alert',$alert);
    }

    public function action_setting()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => 'Главная'], [$this->params['url_site_admin'].'/news' => 'Все новости'], ['current' => 'Настройки']];

        $setting = Kohana::$config->load('news');

        $this->template->content = View::factory('/admin/pages/news/setting')->bind('setting',$setting);
    }
}

