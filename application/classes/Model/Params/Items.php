<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Params_Items extends Model_Base{
	
	protected $_table_name = 'via_params';

	protected $_belongs_to = array(
		'section'  => array(
			'model'       => 'Params_Section',
			'foreign_key' => 'section_id' ,
		)
	);

	public static function check_name($value, $validation, $field)
	{
		$name = ORM::factory('Params_Items')->where('name','=',$value)->find();

		if($name->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_name'));
		}
	}

	public static function obtain($value){

		$param = ORM::factory('Params_Items')->where('name','=',$value)->find();

		return $param->value;
	}

}