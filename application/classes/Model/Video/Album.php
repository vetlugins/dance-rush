<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Video_Album extends ORM{
	
	protected $_table_name = 'via_video_album';

	protected $_has_many  = array(
		'videos'  => array('model' => 'Video_Items', 'foreign_key' => 'album_id')
	);

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function videos(){
		return ORM::factory('Video_Items')
			->where('album_url','=',$this->url)
			->and_where('deleted_at','=',null)
			->find_all();
	}

	public function albums($lang){
		return $this->where('deleted_at','=',null)
			->and_where('lang','=',$lang)
			->order_by('sort','ASC')
			->find_all();
	}

	public function cover(){

		$videos = $this->videos();

		$cover = '';

		if(count($videos)){

			foreach($videos as $video)
			{
				if($video->cover == 1){

					$cover = $video->image;
					break;

				}
				else $cover = '';
			}

		}else $cover = '';

		return $cover;
	}

	public static function check_url($value, $validation, $field, $lang)
	{
		$object = ORM::factory('Video_Album')->where('url','=',$value)->where('lang','=',$lang)->find();

		if($object->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_url'));
		}
	}

}