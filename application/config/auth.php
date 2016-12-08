<?php defined('SYSPATH') OR die('No direct access allowed.');

return array(

    'driver'       => 'ORM',
    'hash_method'  => 'sha256',
    'hash_key'     => 'wigbble',
    'lifetime'     => Date::HOUR * 2,
    'session_key'  => 'Auth_User',

);
