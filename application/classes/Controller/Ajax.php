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
    public function action_load(){

        if(isset($_POST['loadNews'])){

            $offset = $_POST['news'];
            $lang = $this->request->param('lang');
            $config = Kohana::$config->load('blog');

            if(empty($_POST['category'])){
                $article = ORM::factory('Blog_Article')->articles($lang,'offset',$offset);
                $count = count($article);
            }else{
                $category = ORM::factory('Blog_Category')->where('url','=',$_POST['category'])->find();
                $article = $category->articles->articles($lang,'offset',$offset);
                $count = $category->articles->count_all();
            }

            if($count > 0){

                $url_site = $this->lang($lang).'news';

                $post = View::factory( Kohana::$config->load('site.theme').'/news/_snippets/_posts')->bind('posts', $article)
                    ->bind('url_site',$url_site)->bind('config',$config);

                echo $post;

            }else echo 0;

        }

        if(isset($_POST['loadComment'])){

            $config = Kohana::$config->load('blog');

            $offset = $_POST['news'];

            $comments = ORM::factory('Comments')->comments($_POST['id'],'Blog',10,$offset);

            $count = count($comments);

            if($count > 0){

                $show_comments = '';

                foreach($comments as $value){

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
                    $date = $date->get_date($config->get('date_format'));

                    $item_comment = [
                        'comment' => $value->comment,
                        'date' => $date,
                        'photo' => $image,
                        'name' => $username,
                        'city' => $city,
                        'id' => $value->id,
                        'rating' => $value->rating
                    ];

                    $show_comments .= View::factory( Kohana::$config->load('site.theme').'/news/show_comments')->bind('comments',$item_comment);
                }

                echo $show_comments;

            }else echo 0;

        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_save(){

        if(isset($_POST['insertComment'])){

            $error = '';
            $text = '';
            $status = 'ok';

            $config = Kohana::$config->load('blog');

            Cookie::set('time_flud', $config->get('comment_flud'), $config->get('comment_flud_time'));

            $POST = VFunction::checkItem($_POST);

            if($config->get('comment_flud') == 1 and Cookie::get('time_flud') == 1){
                $error = __('Нельзя так часто оставлять комментарии. Попробуйте через '.$config->get('comment_flud_time').' сек.');
            }

            if(Auth::instance()->get_user()){
                $POST['user_id'] = Auth::instance()->get_user()->id;
            }else{

                $name = Validation::factory($POST)
                    ->rule('name','not_empty')
                    ->rule('comment','not_empty');

                if(!$name->check()){
                    $error = __('Пожалуйста! Заполните все обязательные поля.');
                }
            }

            if(empty($error)){

                if($config->get('comment_flud') == 1) Cookie::set('time_flud', $config->get('comment_flud'), $config->get('comment_flud_time'));

                $POST['comment'] = VFunction::html_wrapper($POST['comment']);
                $POST['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                $POST['ip'] = $_SERVER['SERVER_ADDR'];

                $comment = ORM::factory('Comments')->values($POST)->save();

                if($comment->saved()){

                    if($comment->user_id == 0){

                        $username = $comment->name;
                        $city = $comment->city;

                        $image = '/uploads/system/no_avatar.jpg';
                    }else{
                        $username = $comment->author->username;
                        $city = $comment->author->city;

                        if(is_file(DOCROOT.'uploads/users/'.$comment->author->photo)) $image = '/uploads/users/'.$comment->author->photo;
                        else $image = '/uploads/system/no_avatar.jpg';
                    }

                    $date = new DateFormat($comment->created_at);
                    $date = $date->get_date($config->get('date_format'));

                    $item = [
                        'comment' => $comment->comment,
                        'date' => $date,
                        'photo' => $image,
                        'name' => $username,
                        'city' => $city,
                        'id' => $comment->id,
                        'rating' => 0
                    ];

                    $text = View::factory( Kohana::$config->load('site.theme').'/news/show_comments')->bind('comments',$item);
                    $text = '<li>'.$text.'</li>';

                    $email['to'] = 'admin';
                    $email['type'] = 'comment';
                    $email['comment_id'] = $comment->id;

                    SendEmail::factory($email)->send();

                }else{
                    $error = __('Не удалось добавить комментарий');
                    $status = 'error';
                }
            }else{
                $status = 'error';
            }

            $count = ORM::factory('Comments')->count($POST['item_id'],'Blog');

            $json = array('status' => $status,'error' => $error,'comment' => $text,'count' => $count);

            echo json_encode($json);
        }

        if(isset($_POST['likeComment'])){

            $likes = ORM::factory('Comments')->where('id','=',$_POST['id'])->find();

            $count = $likes->rating + 1;
            $likes->set('rating',$count)->update();



            echo $likes->rating;
        }

        if(isset($_POST['insertSubscribe'])){

            $text = '';
            $status = 'ok';

            $POST = VFunction::checkItem($_POST);

            $name = Validation::factory($POST)
                ->rule('email','not_empty')
                ->rule('email','email')
                ->rule('email', 'Model_Subscribe::check_email',array(':value',':validation', ':field'));

            if(!$name->check()){
                $text = __('Пожалуйста! Заполните поле email правильно.');
                $status = 'error';
            }

            if($status == 'ok'){

                $POST['userAgent'] = $_SERVER['HTTP_USER_AGENT'];
                $POST['ip'] = $_SERVER['SERVER_ADDR'];

                $subscribe = ORM::factory('Subscribe')->values($POST)->save();

                if($subscribe->saved()){

                    Cookie::set('email',$subscribe->email);
                    Cookie::set('subscribe',1);

                    $text = __('Спасибо за подписку!');

                    $email['to'] = 'admin';
                    $email['type'] = 'subscribe';
                    $email['subscribe_id'] = $subscribe->id ;

                    SendEmail::factory($email)->send();

                }else{
                    $text = __('Не удалось добавить Вас в базу подписки');
                    $status = 'error';
                }
            }

            $json = array('status' => $status,'text' => $text);

            echo json_encode($json);
        }
    }
////////////////////////////////////////////////////////////////////////////////
    public function action_send(){

        if(isset($_POST['letter'])){

            $status = 'ok';

            if($status == 'ok'){

                $email = [
                    'to' => 'admin',
                    'type' => 'letter',
                    'message' => $_POST['message'],
                    'from_email' => $_POST['email'],
                    'name' => $_POST['name']
                ];

                SendEmail::factory($email)->send();

            }else{
                $status = 'error';
            }

            echo $status;
        }


        if(isset($_POST['enroll'])){

            $status = 'ok';

            if($status == 'ok'){

                if($_POST['enroll'] == 'company'){

                    $email = [
                        'to' => 'admin',
                        'type' => 'enroll',
                        'name' => $_POST['name'],
                        'phone' => $_POST['phone'],
                        'object' => 'company'
                    ];


                }elseif($_POST['enroll'] == 'client'){
                    $email = [
                        'to' => 'admin',
                        'type' => 'enroll',
                        'name' => $_POST['name'],
                        'phone' => $_POST['phone'],
                        'object' => 'client'
                    ];
                }else{
                    $email = [];
                }

                if(count($email))SendEmail::factory($email)->send();
                else $status = 'error';


            }else{
                $status = 'error';
            }

            echo $status;
        }

    }
}