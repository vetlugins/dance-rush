<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Covers extends ORM{
	
	protected $_table_name = 'via_covers';

	private $DIR;
	private $DIR_HOST = '/uploads/';
	private $folder_main = 'original';
	private $folders_default = [
		'original',
		'small',
		'medium'
	];
	private $small = [
		'width'  => 150,
		'height' => 150,
		'master' => Image::AUTO
	];
	private $medium = [
		'width'  => 500,
		'height' => 290,
		'master' => Image::WIDTH
	];

	protected function folders($type){

		$DIR     = $this->DIR.$type.'/';
		$folders = $this->folders_default;

		foreach($folders as $folder){
			if(!file_exists($DIR.$folder)){
				mkdir($DIR.$folder, 0777);
			}
		}

		$scan_dir = scandir($DIR);

		unset($scan_dir[0]);
		unset($scan_dir[1]);

		return $scan_dir;
	}

	public function set_cover($type,$id,$FILES,$setting=[]){

		if(!empty($type) and !empty($id) and !empty($FILES)){

			$DIR         = $this->DIR.$type.'/';
			$upload_dir  = $DIR.$this->folder_main;
			$folders     = $this->folders($type);

			//Меняем название изображения, во избежание совпадении имен.
			$ext = substr($FILES['image']['name'],strpos($FILES['image']['name'],'.'),strlen($FILES['image']['name'])-1);
			$name = $type.'_'.$id.'_'.time().$ext;

			// Загружаем оригинал изображения.
			$filename = Upload::save($FILES['image'], $name, $upload_dir, 0777);

			$cover = Image::factory($filename);

			foreach($folders as $folder){

				if($folder != $this->folder_main){

					$sizes = $this->$folder;

					$cover->resize($sizes['width'], $sizes['width'], $sizes['master'])->save($DIR.$folder.'/'.$name);
				}

			}

			// Накладываем водяной знак
			if(isset($setting['watermark']) and $setting['watermark'] == 1){
				$watermark_filename = DOCROOT.'uploads/watermark/'.Params::obtain('watermark').'.png';
				$watermark = Image::factory($watermark_filename);
				// Водяной знак наклаывается на оригинал
				$cover->watermark($watermark,TRUE, TRUE)->save();
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
			];

			// Проверяем нужно ли заменить ковер
			$check_file = $this->where('object_type','=',$type)->and_where('object_id','=',$id)->find();

			if($check_file->loaded()){
				foreach($folders as $folder){
					if(is_file($DIR.$folder.'/'.$check_file->name)) unlink($DIR.$folder.'/'.$check_file->name);
				}

				$check_file->values($array)->save();
			} else ORM::factory('Covers')->values($array)->save();

			return true;
		}else{
			return false;
		}

	}

	public function get_cover($type,$size){

		$cover = $this->find();
		$image = '';

		if($cover->loaded()){
			if(!empty($size)){
				if(file_exists($this->DIR.$type.'/'.$size.'/'.$cover->name)){
					return $this->DIR_HOST.$type.'/'.$size.'/'.$cover->name;
				}else{
					return $this->DIR_HOST.$type.'/'.$this->folder_main.'/'.$cover->name;
				}
			}else{
				return $this->DIR_HOST.$type.'/'.$this->folder_main.'/'.$cover->name;
			}
		}else{
			if($type == 'users') $image = 'no_avatar.jpg';

			return $cover = $this->DIR_HOST.'no_covers/'.$image;
		}

	}

	public function remove_cover($type,$id){

		$check_file = $this->where('object_type','=',$type)->and_where('object_id','=',$id)->find();
		$DIR        = $this->DIR.$type.'/';
		$folders  	= $this->folders($type);

		if($check_file->loaded()){

			foreach($folders as $folder){
				if(is_file($DIR.$folder.'/'.$check_file->name)) unlink($DIR.$folder.'/'.$check_file->name);
			}

			$check_file->delete();
			return true;
		}

		return false;

	}
}