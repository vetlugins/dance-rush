<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Ajax extends Controller{

	public function action_sort()
    {
        if (Request::initial()->is_ajax())
        {

            $count = 1;

            foreach ($_POST['array_order'] as $id_val) {

                $model = ORM::factory($_POST['model']);

                $item = $model->where('id','=',$id_val)->find();

                $item->set('sort',$count)->save();

                $count ++;
            }

            echo '<div class="alert alert-success">'.Kohana::message('admin', 'alert.success.sort').'</div>';

        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_hideShow()
    {
        if (Request::initial()->is_ajax())
        {
            $item = ORM::factory($_POST['model'])->where('id','=',$_POST['id'])->find();

            if($item->view == 1){
                $item->set('view',0)->save();
                echo '<i class="fa fa-eye-slash"></i>';
            }else{
                $item->set('view',1)->save();
                echo '<i class="fa fa-eye"></i>';
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_soft_delete()
    {
        if (Request::initial()->is_ajax())
        {
            $model = ORM::factory($_POST['model'])->where('id','=',$_POST['id'])->find();
            $model->soft_delete();

            echo '<div class="alert alert-success">'.Kohana::message('admin', 'alert.success.delete_soft').'</div>';

        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_change()
    {
        if (Request::initial()->is_ajax()) {
            if (isset($_POST['changeLangPage'])){

                $list = '<option>'.__('Нет').'</option>';

                $list .= ORM::factory('Page')->get_page_option(array(),$_POST['lang']);

                echo $list;
            }
            if (isset($_POST['changeLangBlogCategory'])){

                $list = ORM::factory('Blog_Category')->get_category_option(array(),$_POST['lang']);

                echo $list;
            }
            if (isset($_POST['changeCoverPhotoAlbum'])){

                $photos = ORM::factory('Photo_Items')->where('album_url','=',$_POST['album'])->find_all();

                foreach($photos as $value) $value->set('cover', 0)->save();

                $photo = ORM::factory('Photo_Items')->where('id','=',$_POST['id'])->find();

                $photo->set('cover', 1)->save();

            }
            if (isset($_POST['changeCoverVideoAlbum'])){

                $photos = ORM::factory('Video_Items')->where('album_url','=',$_POST['album'])->find_all();

                foreach($photos as $value) $value->set('cover', 0)->save();

                $photo = ORM::factory('Video_Items')->where('id','=',$_POST['id'])->find();

                $photo->set('cover', 1)->save();

            }
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_add()
    {
        if (isset($_POST['insertPhotoAlbum'])) {

            $errors = array();

            $_POST = Arr::map('trim', $_POST);

            $value = Validation::factory($_POST)
                ->rule('title', 'not_empty')
                ->rule('url', 'not_empty')
                ->rule('url', 'Model_Photo_Album::check_url',array(':value',':validation', ':field', $_POST['lang']));

            if (!$value->check()) {
                $errors[] = $value->errors('validation');
            }

            if (!count($errors)) {

                ORM::factory('Photo_Album')->values($_POST)->save();

                echo '<p class="text-success">Альбом добавлен</p>';

            } else {
                foreach ($errors as $message) {
                    foreach ($message as $msg) {
                        echo '<p class="text-danger">' . str_replace('validation.url.','',$msg) . '</p>';
                    }
                }
            }
        }
        if (isset($_POST['insertVideoAlbum'])) {

            $errors = array();

            $_POST = Arr::map('trim', $_POST);

            $value = Validation::factory($_POST)
                ->rule('title', 'not_empty')
                ->rule('url', 'not_empty')
                ->rule('url', 'Model_Video_Album::check_url',array(':value',':validation', ':field', $_POST['lang']));

            if (!$value->check()) {
                $errors[] = $value->errors('validation');
            }

            if (!count($errors)) {

                ORM::factory('Video_Album')->values($_POST)->save();

                echo '<p class="text-success">Альбом добавлен</p>';

            } else {
                foreach ($errors as $message) {
                    foreach ($message as $msg) {
                        echo '<p class="text-danger">' . str_replace('validation.url.','',$msg) . '</p>';
                    }
                }
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_edit()
    {
        if (isset($_POST['editPhotoAlbum'])) {

            $errors = array();

            $_POST = Arr::map('trim', $_POST);

            $item = ORM::factory('Photo_Album')->where('id','=',$_POST['id'])->find();

            if($item->loaded()){

                $value = Validation::factory($_POST)
                    ->rule('title', 'not_empty')
                    ->rule('url', 'not_empty');

                if (!$value->check()) {
                    $errors[] = $value->errors('validation');
                }else{
                    if($item->url != $_POST['url']){

                        $check_url = Validation::factory($_POST)
                            ->rule('url', 'Model_Photo_Album::check_url',array(':value',':validation', ':field',$this->request->post('lang')));

                        if(!$check_url->check())
                        {
                            $errors = $check_url->errors('validation');
                        }
                    }
                }

                if (!count($errors)) {

                    $item->values($_POST)->save();

                    echo '<p class="text-success">Альбом обновлен</p>';

                } else {
                    foreach ($errors as $message) {
                        foreach ($message as $msg) {
                            echo '<p class="text-danger">' . str_replace('validation.url.','',$msg) . '</p>';
                        }
                    }
                }

            }else{
                echo '<p class="text-danger">'.Kohana::message('validation', 'not_id').'</p>';
            }

        }
        if (isset($_POST['editVideoAlbum'])) {

            $errors = array();

            $_POST = Arr::map('trim', $_POST);

            $item = ORM::factory('Video_Album')->where('id','=',$_POST['id'])->find();

            if($item->loaded()){

                $value = Validation::factory($_POST)
                    ->rule('title', 'not_empty')
                    ->rule('url', 'not_empty');

                if (!$value->check()) {
                    $errors[] = $value->errors('validation');
                }else{
                    if($item->url != $_POST['url']){

                        $check_url = Validation::factory($_POST)
                            ->rule('url', 'Model_Video_Album::check_url',array(':value',':validation', ':field',$this->request->post('lang')));

                        if(!$check_url->check())
                        {
                            $errors = $check_url->errors('validation');
                        }
                    }
                }

                if (!count($errors)) {

                    $item->values($_POST)->save();

                    echo '<p class="text-success">Альбом обновлен</p>';

                } else {
                    foreach ($errors as $message) {
                        foreach ($message as $msg) {
                            echo '<p class="text-danger">' . str_replace('validation.url.','',$msg) . '</p>';
                        }
                    }
                }

            }else{
                echo '<p class="text-danger">'.Kohana::message('validation', 'not_id').'</p>';
            }

        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_load()
    {
        if (isset($_POST['loadPhotoAlbum'])) {

            $item = ORM::factory('Photo_Album')->where('id','=',$_POST['id'])->find();

            $album = array('title' => $item->title,'url' => $item->url,'lang' => $item->lang,'id' => $item->id);

            echo json_encode($album);
        }
        if (isset($_POST['loadVideoAlbum'])) {

            $item = ORM::factory('Video_Album')->where('id','=',$_POST['id'])->find();

            $album = array('title' => $item->title,'url' => $item->url,'lang' => $item->lang,'id' => $item->id);

            echo json_encode($album);
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_upload()
    {
        if (isset($_POST['uploadPhoto'])) {

            sleep(1);

            $pictures = Validation::factory($_FILES)
                ->rule('file', 'Upload::valid')
                ->rule('file', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG')));

            if($pictures->check()){

                $album = ORM::factory('Photo_Album')->where('url','=',$_POST['album'])->and_where('lang','=','ru')->find();

                $ext = substr($_FILES['file']['name'],strpos($_FILES['file']['name'],'.'),strlen($_FILES['file']['name'])-1);
                $name = 'photo_'.$album->url.'_'.time().$ext;
                $dir = DOCROOT.'uploads/photo/';

                if(is_dir($dir.'original/')) $filename = Upload::save($_FILES['file'], $name, $dir.'original/', 0777);
                else $filename = false;

                if($filename){

                    $watermark_filename = DOCROOT.'uploads/watermark/'.Kohana::$config->load('site.watermark').'.png';
                    $watermark = Image::factory($watermark_filename);

                    Image::factory($filename,'GD')
                        ->resize(500, null, Image::HEIGHT)
                        ->save($dir.'medium/'.$name);

                    Image::factory($filename,'GD')
                        ->resize(200, null, Image::HEIGHT)
                        ->save($dir.'small/'.$name);

                    Image::factory($filename)->watermark($watermark,TRUE, TRUE)->save();

                    $array = array(
                        'album_id' => $album->id,
                        'album_url' => $album->url,
                        'image'     => $name
                    );

                    ORM::factory('Photo_Items')->values($array)->save();

                }
            }

        }
    }
////////////////////////////////////////////////////////////////////////////////
}
?>