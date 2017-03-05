<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Covers extends ORM{
	
	protected $_table_name = 'via_covers';

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}
}