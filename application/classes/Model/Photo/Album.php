<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Photo_Album extends ORM{
	
	protected $_table_name = 'via_photo_album';

	protected $_has_many  = array(
		'photos'  => array('model' => 'Photo_Items', 'foreign_key' => 'album_id')
	);

	public function albums($lang,$view=0){

		if($view == 0){
			return $this->where('lang','=',$lang)
				->where('deleted_at','=',null)
				->order_by('sort','ASC')->find_all();
		}else{
			return $this->where('lang','=',$lang)
				->where('deleted_at','=',null)
				->and_where('view','=',1)
				->order_by('sort','ASC')->find_all();
		}

	}

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function photos(){

		$album = $this->url;

		return ORM::factory('Photo_Items')->where('album_url','=',$album)->where('deleted_at','=',null)->find_all();
	}

	public function cover(){

		$photos = $this->photos();

		$cover = '';

		if(count($photos)){

			foreach($photos as $photo)
			{
				if($photo->cover == 1){

					$cover = $photo->image;
					break;

				}
				else $cover = '';
			}

		}else $cover = '';

		return $cover;
	}

	public static function check_url($value, $validation, $field, $lang)
	{
		$object = ORM::factory('Photo_Album')->where('url','=',$value)->where('lang','=',$lang)->find();

		if($object->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_url'));
		}
	}

}