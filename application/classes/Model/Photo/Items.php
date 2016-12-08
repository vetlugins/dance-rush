<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Photo_Items extends ORM{
	
	protected $_table_name = 'via_photo_item';

	protected $_belongs_to = array(
		'album'  => array(
			'model'       => 'Photo_Album',
			'foreign_key' => 'album_url',
		)
	);

}