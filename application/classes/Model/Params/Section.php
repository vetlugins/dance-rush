<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Params_Section extends Model_Base{
	
	protected $_table_name = 'via_params_section';

	protected $_has_many = array(
		'params' => array(
			'model' => 'Params_Items',
			'foreign_key' => 'section_id',
		),
	);

	public static function check_title($value, $validation, $field)
	{
		$name = ORM::factory('Params_Section')->where('title','=',$value)->find();

		if($name->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_title'));
		}
	}

}