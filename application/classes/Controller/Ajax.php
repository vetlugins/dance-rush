<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Ajax extends Controller{

    protected $url_site;

    protected function lang($lang_uri)
    {
        if($lang_uri == Kohana::$config->load('lang.default') and Kohana::$config->load('lang.hide_default') == 1) $luri = '';
        else $luri = $lang_uri;

        return $this->url_site = URL::site($luri.'/');
    }

////////////////////////////////////////////////////////////////////////////////
    public function action_account()
    {
        if (Request::initial()->is_ajax())
        {
            sleep(4);

            $this->url_site = $this->lang($this->request->param('lang'));

            if($this->request->post('auth') == 'user')
            {

                $remember = array_key_exists('rememberme', $this->request->post()) ? (bool) $this->request->post('rememberme') : FALSE;
                $user = Auth::instance()->login($this->request->post('email'), $this->request->post('password'), $remember);

                if ($user)
                {
                    if (Auth::instance()->logged_in('banned'))
                    {
                        echo Kohana::message('error', 'wrongAuth');
                    }
                    else
                    {

                        $values = array(
                            'user_id' => Auth::instance()->get_user()->id,
                            'date' => time(),
                            'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                            'ip' => $_SERVER["REMOTE_ADDR"],
                        );

                        ORM::factory('Auth_Visit')->values($values)->save();

                        $session = Session::instance(); // стартуем сессии
                        if ($session->get('redirectAfterLogin')!='')
                        {
                            $redirect = $session->get('redirectAfterLogin');
                            $session->delete('redirectAfterLogin');
                            $r = $redirect;
                        }else{
                            $r = $this->url_site;
                        }

                        echo '<script language="Javascript">function reload() {location = \''.$r.'\'}; setTimeout(\'reload()\', 0);</script>';
                    }
                }
                else
                {
                    echo '<div class="alert alert-danger m-b-0" role="alert">
                            <strong>'.__('Ошибка').'!</strong> '.Kohana::message('error', 'wrongAuth').'</div>';
                }
            }

            if($this->request->post('auth') == 'registration')
            {
                $object = Validation::factory($_POST)
                    ->rule('password', 'not_empty')
                    ->rule('email', 'email')
                    ->rule('email', 'Model_Rule::check_email',array(':value', ':validation', ':field'))
                    ->rule('username', 'not_empty');

                if($object->check())
                {
                    $user = ORM::factory('Auth_User')
                        ->set('login', $this->request->post('email'))
                        ->set('email', $this->request->post('email'))
                        ->set('password', $this->request->post('password'))
                        ->set('username', $this->request->post('username'))
                        ->set('date',time())
                        ->save();

                    $user->add('roles', ORM::factory('Auth_Role', array('name' => 'login')));

                    $_POST = array();

                    Auth::instance()->login($this->request->post('email'), $this->request->post('password'));

                    $values = array(
                        'user_id' => Auth::instance()->get_user()->id,
                        'date' => time(),
                        'user_agent' => $_SERVER['HTTP_USER_AGENT'],
                        'ip' => $_SERVER["REMOTE_ADDR"],
                    );

                    ORM::factory('Auth_Visit')->values($values)->save();

                    echo '<script language="Javascript">function reload() {location = \''.$this->url_site.'\'}; setTimeout(\'reload()\', 0);</script>';

                }else{

                    $errors =  $object->errors('error');

                    foreach($errors as $error){
                        echo '<div class="alert alert-danger m-b-0" role="alert">
                            <strong>'.__('Ошибка').'!</strong> '.$error.'</div>';
                    }

                }
            }

            if($this->request->post('auth') == 'forgotPass')
            {
                $object = Validation::factory($_POST)
                    ->rule('email', 'not_empty')
                    ->rule('email', 'email');

                if($object->check())
                {
                    $user = ORM::factory('Auth_User')->where('email','=',$this->request->post('email'))->find();

                    if($user->loaded()){

                        $toEmail = $user->email;
                        $toName = $user->username;

                        $fromEmail = 'bot@kachok.uz';
                        $fromName = 'Робот KA4OK.uz';

                        $subject = __('Запрос на восстановление пароля на сайте KA4OK.uz');

                        $md5 = md5(md5($user->email));

                        $link = $this->url_site.'profile/forgot?link='.$md5;

                        $textForAdmin = '<h3>'.__('Здравствуйте').', '.$toName.'</h3>
                                        <p>'.__('На наш сайт KA4OK.uz поступил запрос на восстановление пароля').'.</p>
                                        <p>'.__('Чтобы восстановить свои пароль и получить доступ к своим данным, пройдите по ссылке ниже').'.</p>
                                        <p>'.$link.'</p>
                                        <p>'.__('Внимание! Мы не оптравляем пароли на почту, ни при каких условиях').'.</p>';

                        $messageForAdmin = View::factory(Kohana::$config->load('main.theme').'/pages/email_tpl')
                            ->bind('text', $textForAdmin)->bind('subject', $subject);

                        $mailer = Email::connect(Kohana::$config->load('email'));

                        $message = Swift_Message::newInstance($subject, $messageForAdmin, 'text/html', 'utf-8');
                        $message->setTo($toEmail, $toName);
                        $message->setFrom($fromEmail,$fromName);
                        $mailer->send($message);


                        echo '<div class="alert alert-success m-b-0" role="alert">
                            <strong>'.__('Успешно').'!</strong> '.__('Ссылка на восстановление пароля отправлена Вам на почту').'</div>';

                    }else{
                        echo '<div class="alert alert-danger m-b-0" role="alert">
                            <strong>'.__('Ошибка').'!</strong> '.__(' Пользователь не найден').'</div>';
                    }

                }else{

                    $errors =  $object->errors('error');

                    foreach($errors as $error){
                        echo '<div class="alert alert-danger m-b-0" role="alert">
                            <strong>Ошибка!</strong> '.$error.'</div>';
                    }

                }
            }

            if($this->request->post('auth') == 'editProfile')
            {
                $error = false;
                $messages = array();

                $value = Validation::factory($_POST)
                    ->rule('username', 'not_empty');

                if(!$value->check())
                {
                    $error = true;
                    $messages[] = $value->errors('error');
                }

                if(!empty($_FILES['profilePhoto'])){

                    $logo = Validation::factory($_FILES)
                        ->rule('profilePhoto', 'Upload::valid')
                        ->rule('profilePhoto', 'Upload::type', array(':value', array('jpg', 'jpeg','JPG', 'JPEG')));

                    if(!$logo->check()){

                        $error = true;
                        $messages[] = $logo->errors('error');

                    }

                }

                if($error == false)
                {
                    $user = ORM::factory('Auth_User')->where('id','=',Auth::instance()->get_user()->id)->find();

                    if(!empty($_FILES['profilePhoto'])){

                        if($user->photo != 'no_avatar.jpg'){
                            if(is_file(DOCROOT.'uploads/user/'.$user->photo)) unlink(DOCROOT.'uploads/user/'.$user->photo);
                        }

                        $ext = substr($_FILES['profilePhoto']['name'],strpos($_FILES['profilePhoto']['name'],'.'),strlen($_FILES['profilePhoto']['name'])-1);
                        $photo = 'user_'.$user->id.'_'.time().$ext;
                        $dir = DOCROOT.'uploads/user/';

                        Upload::save($_FILES['profilePhoto'], $photo, $dir, 0777);

                    }else{
                        $photo = $user->photo;
                    }

                    $pass = $this->request->post('password');

                    if(!empty($pass)) $user->set('password',$pass);

                    $array = array(
                        'username'    => $this->request->post('username'),
                        'photo'       => $photo,
                    );

                    $user->values($array)->save();

                    echo '<div class="alert alert-success m-b-0 no-bordered" role="alert">
                            <strong>'.__('Успешно').'!</strong> '.__('Ваши данные обновлены').'</div>';

                }else{

                    foreach($messages as $message){
                        foreach($message as $msg){
                            echo '<div class="alert alert-danger m-b-0 no-bordered"><strong>'.__('Ошибка').'!</strong> '.$msg.'</div>';
                        }
                    }

                }
            }
        }
    }
////////////////////////////////////////////////////////////////////////////////

}