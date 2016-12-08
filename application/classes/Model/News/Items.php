<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_News_Items extends ORM{
	
	protected $_table_name = 'via_news';

	protected $_has_many  = array(
		'comments'  => array('model' => 'News_Comment', 'foreign_key' => 'post_id')
	);

	protected $_belongs_to = array(
		'author'  => array(
			'model'       => 'Auth_User',
			'foreign_key' => 'user_created',
		)
	);

	public function where_soft(){
		return $this->where('deleted_at','=',null);
	}

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function getAllNews($lang){
		return $this->where('lang', '=', $lang)
			->and_where('deleted_at','=',null)
			->order_by('id','DESC')
			->find_all();
	}
}