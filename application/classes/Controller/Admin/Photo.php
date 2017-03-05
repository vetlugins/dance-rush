<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Photo extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'photo';
        $this->page = array(
            'icon'=>'fa-photo',
            'title' => Kohana::message('admin', 'titles.'.$this->params['module'].'.title'),
            'description' => Kohana::message('admin', 'titles.'.$this->params['module'].'.description')
        );

        $this->template->plugin_specific = array(
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrapValidator/bootstrapValidator.min',
            'dropzone/dropzone.min',
            'fancybox/jquery.fancybox',
        );
        $this->template->styles_specific = array(
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'bootstrapValidator/bootstrapValidator.min',
            'fancybox/jquery.fancybox',
            'dropzone/dropzone'
        );
    }

    public function action_index()
    {
        $this->params['model'] = 'Photo_Album';
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
        $this->params['model'] = 'Photo_Album';
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => Kohana::message('admin', 'home')], [$this->params['url_site_admin'].'/'.$this->params['module'] => Kohana::message('admin', 'titles.'.$this->params['module'].'.title')], ['current' => Kohana::message('admin', 'titles.'.$this->params['module'].'.upload_item')]];

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/upload');
    }

    public function action_show()
    {
        $this->params['model'] = 'Photo_Album';
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = [[$this->params['url_site_admin'] => Kohana::message('admin', 'home')], [$this->params['url_site_admin'].'/'.$this->params['module'] => Kohana::message('admin', 'titles.'.$this->params['module'].'.title')], ['current' => Kohana::message('admin', 'titles.'.$this->params['module'].'.show_item')]];

        $id = $this->request->param('id');

        $album = $model->where('url','=',$id)->and_where('lang','=','ru')->find();

        $photos = $album->photos();

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/show')
            ->bind('album',$album)
            ->bind('photos',$photos);
    }

}

