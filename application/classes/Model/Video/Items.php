<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Video_Items extends ORM{
	
	protected $_table_name = 'via_video_item';

	protected $_has_many = array(
		'news'     => array('model' => 'News_Items', 'through' => 'via_route_news','foreign_key' => 'video_id')
	);

	protected $_has_one = array(
		'title' => array(
			'model' => 'Video_Title',
			'foreign_key' => 'video_id',
		)
	);

	protected $_belongs_to = array(
		'album'  => array(
			'model'       => 'Video_Album',
			'foreign_key' => 'album_id',
		)
	);

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}
}