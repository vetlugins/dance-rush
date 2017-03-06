<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Params extends ORM{
	
	protected $_table_name = 'via_site_setting';

	public function section($id){

		return $this->where('section', '=', $id)->find_all();

	}

	public static function check_name($value, $validation, $field)
	{
		$name = ORM::factory('Params')->where('name','=',$value)->find();

		if($name->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_name'));
		}
	}

	public static function obtain($value){

		$param = ORM::factory('Params')->where('name','=',$value)->find();

		return $param->value;
	}

}