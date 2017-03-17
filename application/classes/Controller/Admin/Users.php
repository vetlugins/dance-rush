<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Admin_Users extends Controller_Admin_Common {

    public function before()
    {
        parent::before();

        $this->params['module'] = 'users';
        $this->params['model'] = 'Auth_User';

        $this->page = array(
            'icon'=>'fa-users',
            'title' => __('Пользователи сайта'),
            'description' => __('управление пользователями сайта')
        );

        $this->template->plugin_specific = array(
            'jgrowl/jquery.jgrowl',
            'switchery/switchery.min',
            'bootstrapValidator/bootstrapValidator.min',
            'fancybox/jquery.fancybox',
            'bootstrap-file-input/bootstrap-file-input',
            'select2/js/select2.min',
            'inputmask/jquery.inputmask',
            'datatables/jquery.dataTables',
            'datatables/dataTables.bootstrap',
            'pass-show-hide/bootstrap-show-password.min'
        );
        $this->template->styles_specific = array(
            'switchery/switchery.min',
            'jgrowl/jquery.jgrowl',
            'bootstrapValidator/bootstrapValidator.min',
            'fancybox/jquery.fancybox',
            'select2/css/select2.min'
        );


    }

    public function action_index()
    {
        $model = ORM::factory($this->params['model']);

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array('current' => __('Пользователи сайта'))
        );

        $users = $model->find_all();

        $list_users = '';

        foreach($users as $user){

            $visit = $user->visit->order_by('id','DESC')->find();

            $list_users .= View::factory('/admin/'.$this->params['module'].'/list')->bind('user',$user)->bind('visit',$visit);
        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/all')
            ->bind('users',$list_users);
    }

    public function action_add()
    {
        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array($this->params['url_site_admin'].'/'.$this->params['module'] => __('Пользователи сайта')),
            array('current' => __('Добавление пользователя'))
        );

        $roles = ORM::factory('Auth_Role')->where('name','!=','superadmin')->find_all();

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

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/edit')
            ->bind('item',$item)
            ->bind('alert',$alert)
            ->bind('roles',$roles);
    }

    public function action_store()
    {
        $model = ORM::factory($this->params['model']);

        $alert = '';
        $errors = [];

        $_POST = Arr::map('trim', $_POST);

        $value = Validation::factory($_POST)
            ->rule('login', 'not_empty')
            ->rule('login', 'Model_'.$this->params['model'].'::check_login',array(':value',':validation', ':field'))
            ->rule('email', 'not_empty')
            ->rule('email', 'Model_'.$this->params['model'].'::check_email',array(':value',': ', ':field'))
            ->rule('role', 'not_empty')
            ->rule('password', 'not_empty')
            ->rule('password', 'alpha_dash');


        if(!empty($_FILES['image']['name'])){

            $value_image = Validation::factory($_FILES)
                ->rule('image', 'Upload::valid')
                ->rule('image', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG','png', 'PNG')));

            if(!$value_image->check()){
                $errors[] = $value_image->errors('validation');
            }

        }

        if(!$value->check())
        {
            $errors[] = $value->errors('validation');
        }

        if(!count($errors)){

            $post_roles = $_POST['role'];
            $_POST['password_confirm'] = $_POST['password'];
            $key = $_POST;

            unset($_POST['addUser']);
            unset($_POST['role']);
            unset($key['password_confirm']);

            $key = array_keys($key);

            $item = $model->create_user($_POST,$key);

            if($item){

                $roles = [];

                foreach($post_roles as $role) $roles['name'] = $role;

                $item->add('roles', ORM::factory('Auth_Role',$roles));

                if(!empty($_FILES['image']['name'])){

                    $folders = [];
                    $setting = [
                        'cut' => [],
                        'coverable' => 1
                    ];

                    Cover::set_cover($this->params['module'],$item->id,$_FILES,$folders,$setting);
                }

                $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно создана').'</p></div>';

                Session::instance()->set('alert',$alert);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->login.'/edit');

            }else{

                $alert .= '<div class="alert alert-danger"><p>'.__('Не удалось создать запись').'</p></div>';

                Session::instance()->set('alert',$alert)->set('item',$_POST);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/add');
            }

        }else{

            foreach($errors as $error){
                foreach($error as $value)
                $alert .= '<div class="alert alert-danger"><p>'.$value.'</p></div>';
            }

            Session::instance()->set('alert',$alert)->set('item',$_POST);

            HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/add');
        }

    }

    public function action_edit()
    {
        $model = ORM::factory($this->params['model']);
        $id = $this->request->param('id');
        $user = $model->where('login','=',$id)->find();

        $this->page['breadcrumb'] = array(
            array($this->params['url_site_admin'] => __('Главная')),
            array($this->params['url_site_admin'].'/'.$this->params['module'] => __('Пользователи сайта')),
            array('current' => $user->username)
        );

        if(Session::instance()->get('alert')) $alert = Session::instance()->get_once('alert');
        else $alert = '';

        $roles = ORM::factory('Auth_Role')->where('name','!=','superadmin')->find_all();
        $user_roles = $user->roles->find_all();

        $user_roles_array = [];
        foreach($user_roles as $role){
            $user_roles_array[$role->id][] = $role->name;
        }

        $visits = $user->visit->group_by('date')->order_by('id','DESC')->find_all();

        $show_visit = [];

        foreach($visits as $visit){

            $date = date('Y-m-d H:i:s',$visit->date);
            $date = new DateFormat($date);

            $browser = new Browser($visit->user_agent);

            $show_visit[] = [
                'ip'             => $visit->ip,
                'date'           => $date->get_date('d F Y в H:i'),
                'browser'        => $browser->getBrowser(),
                'browserVersion' => $browser->getVersion(),
                'platform'       => $browser->getPlatform()
            ];

        }

        $this->template->content = View::factory('/admin/'.$this->params['module'].'/edit')
            ->bind('alert',$alert)
            ->bind('roles',$roles)
            ->bind('user_roles',$user_roles_array)
            ->bind('item',$user)
            ->bind('id',$id)
            ->bind('visits',$show_visit);
    }

    public function action_update()
    {
        $model = ORM::factory($this->params['model']);

        $id = $this->request->post('login');

        $item = $model->where('login','=',$id)->find();

        if($item->loaded()){

            $alert = '';
            $errors = [];

            $_POST = Arr::map('trim', $_POST);

            $value = Validation::factory($_POST)
                ->rule('username', 'not_empty')
                ->rule('role', 'not_empty');

            if(!$value->check()){
                $errors[] = $value->errors('validation');
            }

            if(!empty($_POST['password'])){
                $_POST['password_confirm'] = $_POST['password'];

                $password_validation  = Validation::factory($_POST)
                    ->rule('password', 'alpha_dash');

                if(!$password_validation->check()){
                    $errors[] = $password_validation->errors('validation');
                }
            }

            if(!empty($_FILES['image']['name'])){

                $value_image = Validation::factory($_FILES)
                    ->rule('image', 'Upload::valid')
                    ->rule('image', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG','png', 'PNG')));

                if(!$value_image->check()){
                    $errors[] = $value_image->errors('validation');
                }

            }

            if(!count($errors)){

                $super_admin = $item->super_admin();

                if($super_admin) unset($_POST['password']);

                $item->update_user($_POST);

                if($item){
                    if(!empty($_FILES['image']['name'])){

                        $folders = [];
                        $setting = [
                            'cut' => [],
                            'coverable' => 1
                        ];

                        Cover::set_cover($this->params['module'],$item->id,$_FILES,$folders,$setting);
                    }

                    $alert .= '<div class="alert alert-success"><p>'.__('Запись успешно изменена').'</p></div>';

                    Session::instance()->set('alert',$alert);

                    HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->login.'/edit');
                }else{
                    echo __('Произошла какая то не понятная ошибка'); die;
                }

            }else{

                foreach($errors as $error) $alert .= '<div class="alert alert-danger"><p>'.$error.'</p></div>';

                Session::instance()->set('alert',$alert)->set('item',$_POST);

                HTTP::redirect($this->params['url_site_admin'].'/'.$this->params['module'].'/'.$item->login.'/edit');
            }

        }else{
            echo __('Произошла какая то не понятная ошибка'); die;
        }

    }

    public function action_remove(){



    }

    public function action_logout(){

        Auth::instance()->logout();

        HTTP::redirect('/');

    }

}

