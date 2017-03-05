<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Subscribe extends ORM{
	
	protected $_table_name = 'via_subscribe';

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}


	public static function check_email($value, $validation, $field)
	{
		$page = ORM::factory('Subscribe')->where('email','=',$value)->find();

		if($page->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_email'));
		}
	}

}