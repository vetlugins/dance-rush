<?php defined('SYSPATH') or die('No direct script access.');

class Cover extends Model_Covers{

    static function set_cover($type,$id,$FILES,$folders=[],$setting=[]){

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

}