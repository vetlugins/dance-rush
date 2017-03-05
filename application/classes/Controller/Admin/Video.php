<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Video extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'video';
        $this->params['model'] = 'Video_Album';

        $this->page = array(
            'icon'=>'fa-film',
            'title' => Kohana::message('admin', 'titles.'.$this->params['module'].'.title'),
            'description' => Kohana::message('admin', 'titles.'.$this->params['module'].'.description')
        );

        $this->template->plugin_specific = array(
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrap-file-input/bootstrap-file-input',
            'bootstrapValidator/bootstrapValidator.min',
            'fancybox/jquery.fancybox.pack',
            'fancybox/helpers/jquery.fancybox-thumbs',
            'fancybox/helpers/jquery.fancybox-media',
        );
        $this->template->styles_specific = array(
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'bootstrapValidator/bootstrapValidator.min',
            'fancybox/jquery.fancybox',
            'fancybox/jquery.fancybox-thumbs',
        );
        $this->template->script_specific = array('video');
    }

    public function action_index()
    {
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => Kohana::message('admin', 'home')],['current' => Kohana::message('admin', 'titles.'.$this->params['module'].'.title')]];

        $items = array();

        $i = 1;

        foreach($this->languages as $lang){

            $all_albums = $model->albums($lang->i18n);

            $list = '';

            foreach($all_albums as $album){

                $list .= View::factory('/admin/'.$this->params['module'].'/list')
                    ->bind('album', $album);

                $items[$lang->i18n] = $list;

                $i++;
            }
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/all')
            ->bind('items',$items);
    }

    public function action_upload()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => Kohana::message('admin', 'home')], [$this->params['url_site_admin'].'/'.$this->params['module'] => Kohana::message('admin', 'titles.'.$this->params['module'].'.title')], ['current' => Kohana::message('admin', 'titles.'.$this->params['module'].'.upload_item')]];

        if(Session::instance()->get('alert')){
            $alert = Session::instance()->get_once('alert');
        }
        else {
            $alert = '';
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/upload')->bind('alert',$alert);
    }

    public function action_show()
    {
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => Kohana::message('admin', 'home')], [$this->params['url_site_admin'].'/'.$this->params['module'] => Kohana::message('admin', 'titles.'.$this->params['module'].'.title')], ['current' => Kohana::message('admin', 'titles.'.$this->params['module'].'.show_item')]];

        $id = $this->request->param('id');

        $album = $model->where('url','=',$id)->and_where('lang','=','ru')->find();

        $items = $album->videos();

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/show')
            ->bind('album',$album)
            ->bind('items',$items);
    }

    public function action_store()
    {
        $this->params['model'] = 'Video_Items';
        $model = ORM::factory($this->params['model']);

        $alert = '';
        $errors = array();

        $_POST = Arr::map('trim', $_POST);

        $value = Validation::factory($_POST)
            ->rule('url', 'not_empty');

        if(!$value->check())
        {
            $errors = $value->errors('validation');
        }else{
            if(!empty($_FILES['image']['name'])){
                $image = Validation::factory($_FILES)
                    ->rule('image', 'Upload::valid')
                    ->rule('image', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG')));

                if(!$image->check()){
                    $errors = $value->errors('validation');
                }
            }
        }

        if(!count($errors)){

            if(!empty($_FILES['image']['name'])){
                $_POST['image'] = $this->setCover($_FILES,$item = array());
            }

            if(isset($_POST['view'])) $_POST['view'] = 1;
            else $_POST['view']  = 0;

            $item = $model->values($_POST)->save();

            $alert .= '<div class="alert alert-success"><p>'.Kohana::message('admin', 'alert.success.create').'</p></div>';

            Session::instance()->set('alert',$alert);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/upload?album='.$this->request->post('album_url'));

        }else{

            foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

            Session::instance()->set('alert',$alert)->set('item',$_POST);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/upload?album='.$this->request->post('album_url'));
        }

    }

    protected function setCover($files,$item){

        if(!empty($item)){
            if(is_file(DOCROOT.'/uploads/news/original/'.$item->image)) unlink(DOCROOT.'/uploads/video/'.$item->image);
        }

        $ext = substr($files['image']['name'],strpos($files['image']['name'],'.'),strlen($files['image']['name'])-1);
        $name = 'video_'.time().$ext;
        $dir = DOCROOT.'uploads/video/';

        $filename = Upload::save($files['image'], $name, $dir, 0777);

        $watermark_filename = DOCROOT.'uploads/watermark/'.Kohana::$config->load('site.watermark').'.png';
        $watermark = Image::factory($watermark_filename);

        Image::factory($filename)->watermark($watermark,TRUE, TRUE)->save();

        return $name;

    }
}

