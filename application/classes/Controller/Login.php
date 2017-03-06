<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Login extends Controller_Template{

    public $template = 'login/home';

////////////////////////////////////////////////////////////////////////////////
    public function action_index()
    {

        /*Основные настройки сайта*/
        $params = array(
            'config'   => Kohana::$config->load('site'),
            'url_site' => URL::site(),
            'url_base' => URL::base(),
            'theme'    => '/templates/admin/'
        );

        View::bind_global('params', $params);

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
                        $r = 'admin';
                    }

                    echo '<script language="Javascript">function reload() {location = \''.$r.'\'}; setTimeout(\'reload()\', 0);</script>';
                }
            }
            else
            {
                $error =  '<div class="alert alert-danger no-border" role="alert">
                            <strong>'.__('Ошибка').'!</strong> '.Kohana::message('error', 'user.wrongAuth').'</div>';

                View::bind_global('error', $error);
            }
        }

    }
}
