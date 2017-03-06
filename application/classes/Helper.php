<?php defined('SYSPATH') or die('No direct script access.');

class  Helper {

    static function translate($s) {
        $s = (string) $s;
        $s = strip_tags($s);
        $s = str_replace(array("\n", "\r"), " ", $s);
        $s = preg_replace("/\s+/", ' ', $s);
        $s = trim($s);
        $s = function_exists('mb_strtolower') ? mb_strtolower($s) : strtolower($s);
        $s = strtr($s, array('а'=>'a','б'=>'b','в'=>'v','г'=>'g','д'=>'d','е'=>'e','ё'=>'e','ж'=>'j','з'=>'z','и'=>'i','й'=>'y','к'=>'k','л'=>'l','м'=>'m','н'=>'n','о'=>'o','п'=>'p','р'=>'r','с'=>'s','т'=>'t','у'=>'u','ф'=>'f','х'=>'h','ц'=>'c','ч'=>'ch','ш'=>'sh','щ'=>'shch','ы'=>'y','э'=>'e','ю'=>'yu','я'=>'ya','ъ'=>'','ь'=>''));
        $s = preg_replace("/[^0-9a-z-_ ]/i", "", $s);
        $s = str_replace(" ", "_", $s);
        return $s;
    }

    static function setCover($type,$id,$FILES,$folders=[],$setting=[]){

        // Основна директория загрузки
        $DIR = DOCROOT.'/uploads/'.$type.'/';

        //Меняем название изображения, во избежание совпадении имен
        $ext = substr($FILES['image']['name'],strpos($FILES['image']['name'],'.'),strlen($FILES['image']['name'])-1);
        $name = $type.'_'.$id.'_'.time().$ext;

        // Если заменяем старое изображение на новое. Удаляем старое.
        if($folders){
            if(isset($setting['item'])){
                foreach($folders as $folder){
                    if(is_file($DIR.$folder.'/'.$setting['item'])) unlink($DIR.$folder.'/'.$setting['item']);
                }
            }
        }

        // Загружаем оригинал изображение. ОСНОВНАЯ ДИРЕКТОРИЯ ДЛЯ ИСХОДНЫХ ИЗОБРАЖЕНИЙ ДОЛЖНА НАЗВАТЬСЯ original
        $filename = Upload::save($FILES['image'], $name, $DIR.'original/', 0777);

        //Если нужно обрезать изображение
        if(isset($setting['cut'])){
            //то и должны быть соответствующие директории
            foreach($folders as $folder){
                if(isset($setting['cut'][$folder])){
                    Image::factory($filename,'GD')
                        ->resize($setting['cut'][$folder]['width'], $setting['cut'][$folder]['height'], Image::AUTO)
                        ->save($DIR.$folder.'/'.$name);
                }
            }
        }

        // Накладываем водяной знак
        if(isset($setting['watermark']) and $setting['watermark'] == 1){
            $watermark_filename = DOCROOT.'uploads/watermark/'.Kohana::$config->load('site.watermark').'.png';
            $watermark = Image::factory($watermark_filename);
            // Водяной знак наклаывается на оригинал
            Image::factory($filename)->watermark($watermark,TRUE, TRUE)->save();
        }

        //Если нам оригинал не нужен, удаляем его
        if(isset($setting['remove_original']) and $setting['remove_original'] == 1){
            unlink($filename);
        }

        //Теперь все это сохраняем в базе
        $array = [
            'object_type' => $type,
            'object_id' => $id,
            'name' => $name,
            'coverable' => $setting['coverable']?$setting['coverable']:0
        ];

        return ORM::factory('Covers')->values($array)->save();
    }

    static function checkItem($POST){

        $array = array();

        foreach($POST as $key=>$value){
            $array[$key] = stripslashes(htmlspecialchars($value));
        }

        return $array;
    }

    static function html_wrapper($text){

        $text = nl2br($text);

        $text= preg_replace("/(^|[\n ])([\w]*?)((ht|f)tp(s)?:\/\/[\w]+[^ \,\"\n\r\t<]*)/is", "$1$2<a href=\"$3\" target='_blank' >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([\w]*?)((www|ftp)\.[^ \,\"\t\n\r<]*)/is", "$1$2<a href=\"http://$3\" target='_blank' >$3</a>", $text);
        $text= preg_replace("/(^|[\n ])([a-z0-9&\-_\.]+?)@([\w\-]+\.([\w\-\.]+)+)/i", "$1<a href=\"mailto:$2@$3\">$2@$3</a>", $text);

        return $text;
    }

    static function aprint($arr,$action = '') {
        echo '<pre>';
            print_r ( $arr );
        echo '</pre>';

        if(!empty($action)){

            switch($action){
                case 'die'; die;
            }

        }
    }
}