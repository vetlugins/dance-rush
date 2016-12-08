<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Photo_Album extends ORM{
	
	protected $_table_name = 'via_photo_album';

	protected $_has_many  = array(
		'photos'  => array('model' => 'Photo_Items', 'foreign_key' => 'album_id')
	);

	public function cover(){

		$photos = $this->photos->find_all();

		$cover = '';

		if(count($photos)){

			foreach($photos as $photo)
			{
				if($photo->cover == 1){

					$cover = $photo->image;
					break;

				}
				else $cover = 'nophoto.jpg';
			}

		}else $cover = 'nophoto.jpg';

		return $cover;
	}

}