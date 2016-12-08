<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Photo extends Controller_Admin_Common {

    private $model_album;
    private $model_item;

    public function before()
    {
        parent::before();

        $this->model_album = ORM::factory('Photo_Album');
        $this->model_item = ORM::factory('Photo_Items');

        $this->params['module'] = 'photo';
        $this->page = array(
            'icon'=>'fa-sitemap',
            'title' => 'Фотогалерея',
            'description' => 'управление фотографиями и альбомами фотогалереи сайта'
        );

        $this->template->plugin_specific = array(
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrapValidator/bootstrapValidator.min',
            'liTranslit/jquery.liTranslit',
            'ckeditor/ckeditor'
        );
        $this->template->styles_specific = array(
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'bootstrapValidator/bootstrapValidator.min',
        );
        $this->template->script_specific = array('page');
    }

    public function action_album()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => 'Главная'],['current' => 'Фотоальбомы']];

        $all_albums = $this->model_album->find_all();

        $items = '';

        foreach($all_albums as $album){

            $items .= View::factory('/admin/pages/photo/list')
                ->bind('album', $album);

        }

        $this->template->content = View::factory('/admin/pages/photo/all')
            ->bind('items',$items);
    }

    public function action_add()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => 'Главная'], [$this->params['url_site_admin'].'/pages' => 'Список страниц'], ['current' => 'Добавление страницы']];

        $alert = '';

        if (isset($_POST['addPage'])){

            $_POST = Arr::map('trim', $_POST);

            $value = Validation::factory($_POST)
                ->rule('title', 'not_empty');

            if($value->check())
            {
                $_POST['url'] = VFunction::translit($_POST['title']);

                if(isset($_POST['view'])) $_POST['view'] = 1;
                else $_POST['view']  = 0;

                $this->model->values($_POST)->save();

                $alert .= '<div class="alert alert-success"><p>'.Kohana::message('success', 'admin.page.add').'</p></div>';
            }else{
                $errors = $value->errors('validation');

                foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';
            }
        }

        $pages_option = $this->model->get_page_option();

        $roles = ORM::factory('Auth_Role')->order_by('id','DESC')->find_all();

        $this->template->content = View::factory('/admin/pages/page/add')
            ->bind('pages_option',$pages_option)
            ->bind('alert',$alert)
            ->bind('roles',$roles);
    }

    public function action_edit()
    {
        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => 'Главная'], [$this->params['url_site_admin'].'/pages' => 'Список страниц'], ['current' => 'Редактирование страницы']];

        $id = $this->request->param('id');
        $alert = '';

        if($id){

            $item = $this->model->where('id','=', $id)->and_where('deleted_at','=',null)->find();

            if (isset($_POST['editPage'])){

                $_POST = Arr::map('trim', $_POST);

                $value = Validation::factory($_POST)
                    ->rule('title', 'not_empty');

                if($value->check())
                {
                    $_POST['url'] = $item->url;

                    if(isset($_POST['view'])) $_POST['view'] = 1;
                    else $_POST['view']  = 0;

                    $this->model->where('id','=',$id)->values($_POST)->save();

                    $alert .= '<div class="alert alert-success"><p>'.Kohana::message('success', 'admin.page.edit').'</p></div>';
                }else{
                    $errors = $value->errors('validation');

                    foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';
                }
            }

            $pages_option = $this->model->get_page_option([],$item->lang,$item->parent_id);

            $roles = ORM::factory('Auth_Role')->order_by('id','DESC')->find_all();

        }else{
            $alert = '<div class="alert alert-danger"><p>'.Kohana::message('validation', 'not_id').'</p></div>';
        }

        $this->template->content = View::factory('/admin/pages/page/edit')
            ->bind('item',$item)
            ->bind('pages_option',$pages_option)
            ->bind('alert',$alert)
            ->bind('roles',$roles);
    }

    public function get_parent($pages){

        $list = '';

        foreach($pages as $parent){

            $parents = $this->model->getAllPages($parent->lang,$parent->id);

            if(count($parents) > 0){
                $get_parents = $this->get_parent($parents);
            }

            $list .= View::factory('/admin/pages/page/list')
                ->bind('page', $parent)
                ->bind('parents', $parents)
                ->bind('get_parents', $get_parents);
        }

        return $list;
    }


}

