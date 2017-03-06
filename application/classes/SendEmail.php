<?php defined('SYSPATH') or die('No direct script access.');

class SendEmail{

    protected $from = ['name'=>'Bot', 'email' => 'bot@dance-rush.ru'];
    protected $data = array();
    public $error = array();

    public function __construct($email){

        switch($email['type']){
            case 'comment':
                    $this->send_comment($email);
                break;

            case 'subscribe':
                $this->send_subscribe($email);
                break;

            case 'letter':
                $this->send_letter($email);
                break;

            case 'enroll':
                $this->send_enroll($email);
                break;
        }
    }

    static function factory(array $email){
        return new SendEmail($email);
    }

    protected function send_comment($email){

        $config = Kohana::$config->load('blog');
        $comment = ORM::factory('Comments')->where('id','=',$email['comment_id'])->find();

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
            'name' => $username,
            'city' => $city,
            'article' => $comment->article->title
        ];

        $letter = View::factory('email/comments')->bind('item',$item);

        $this->data['to'] = $this->recipient($email['to']);
        $this->data['subject'] = 'Новый комментарий с Вашего сайта '.Kohana::$config->load('site.site_domain');
        $this->data['message'] = View::factory('email/main')->bind('content',$letter);

        return $this->data;
    }

    protected function send_subscribe($email){

        $subscribe = ORM::factory('Subscribe')->where('id','=',$email['subscribe_id'])->find();

        $date = new DateFormat($subscribe->created_at);
        $date = $date->get_date('d.F.Y в H:i');

        $item = [
            'email' => $subscribe->email,
            'date' => $date,
            'ip' => $subscribe->ip,
            'userAgent' => $subscribe->userAgent
        ];

        $letter = View::factory('email/subscribe')->bind('item',$item);

        $this->data['to'] = $this->recipient($email['to']);
        $this->data['subject'] = 'Новый подписчик на Вашем сайте '.Kohana::$config->load('site.site_domain');
        $this->data['message'] = View::factory('email/main')->bind('content',$letter);

        return $this->data;
    }

    protected function send_letter($email){

        $to = '';

        foreach($this->recipient($email['to']) as $val){
            $to .= $val.',';
        }

        $to .= $this->from['email'];

        $array = [
            'subject'    => 'Новое письмо с Вашего сайта - '.Kohana::$config->load('site.site_domain'),
            'from_email' => $email['from_email'],
            'to_email'   => $to,
            'message'    => $email['message'],
            'name'       => $email['name'],
            'folder_id'  => 1,
            'new'        => 1
        ];

        $letter = ORM::factory('Mail_Letter')->values($array)->save();

        $date = new DateFormat($letter->created_at);
        $date = $date->get_date('d.F.Y в H:i');

        $item = [
            'email'   => $email['from_email'],
            'name'    => $email['name'],
            'message' => $email['message'],
            'date'    => $date
        ];

        $letter = View::factory('email/letter')->bind('item',$item);

        $this->data['to'] = $this->recipient($email['to']);
        $this->data['subject'] = $array['subject'];
        $this->data['message'] = View::factory('email/main')->bind('content',$letter);

        return $this->data;
    }

    protected function send_enroll($email){

        if($email['object'] == 'company') $enroll = 'Новая заявка от компании на Вашем сайте - '.Kohana::$config->load('site.site_domain');
        else $enroll = 'Новая заявка на участие в студии с Вашего сайта - '.Kohana::$config->load('site.site_domain');

        $date = new DateFormat(date('Y-m-d H:i:s'));
        $date = $date->get_date('d.F.Y в H:i');

        $item = [
            'name'    => $email['name'],
            'phone'   => $email['phone'],
            'date'    => $date,
            'enroll'  => $enroll
        ];

        $letter = View::factory('email/enroll')->bind('item',$item);

        $this->data['to'] = $this->recipient($email['to']);
        $this->data['subject'] = $enroll;
        $this->data['message'] = View::factory('email/main')->bind('content',$letter);

        return $this->data;
    }

    protected function recipient($to){

        $recipient = array(Kohana::$config->load('site.email'));

        $users = ORM::factory('Auth_User')->find_all();

        switch ($to){
            case 'admin':
                foreach ($users as $user) {

                    $roles = $user->roles->find_all();

                    foreach ($roles as $role) {

                        if ($role->name == 'admin') $recipient[] = $user->email;

                    }

                }
                break;
            default:
                $recipient[] = $to;
                break;
        }

        return $recipient;
    }

    public final function send(){

        if(empty($this->error)){

            $headers = "MIME-Version: 1.0\r\n";
            $headers .= "Content-type: text/html; charset=utf-8\r\n";
            $headers .= "From: ".$this->from['name']." <".$this->from['email'].">\r\n";

            foreach($this->data['to'] as $email){
                mail( $email, $this->data['subject'], $this->data['message'], $headers );
            }

            return true;

        }else{
            return false;
        }
    }
}