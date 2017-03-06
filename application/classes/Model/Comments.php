<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Comments extends ORM{
	
	protected $_table_name = 'via_comments';

	protected $_belongs_to = array(
		'author'  => array(
			'model'       => 'Auth_User',
			'foreign_key' => 'user_id',
		),
		'article'  => array(
			'model'       => 'Blog_Article',
			'foreign_key' => 'item_id',
		)
	);

	public function where_soft(){
		return $this->where('deleted_at','=',null);
	}

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function type($key){
		return $this->where('item_type','=', $key);
	}

	public function comments($id,$type,$limit,$offset=0){
		return $this->where('item_type','=', $type)
			->where('item_id','=',$id)
			->where_soft()
			->order_by('id','DESC')
			->offset($offset)
			->limit($limit)
			->find_all();
	}

	public function count($id,$type){
		return $comments = $this->where('item_type','=', $type)
			->where('item_id','=',$id)
			->where_soft()
			->count_all();
	}
}