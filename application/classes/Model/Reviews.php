<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Reviews extends ORM{
	
	protected $_table_name = 'via_reviews';

	public function where_soft(){
		return $this->where('deleted_at','=',null);
	}

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}
}