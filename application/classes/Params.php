<?php defined('SYSPATH') or die('No direct script access.');

class  Params extends Model_Params_Items {

    public static function plugins(){
        return URL::base().'templates/plugins/';
    }

    public static function theme(){
        return URL::base().'templates/'.self::obtain('theme').'/';
    }

}