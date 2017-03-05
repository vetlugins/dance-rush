<?php defined('SYSPATH') or die('No direct script access.');

/**
 * Settings Model 
 *
 * @package    Kohana-Settings
 * @category   Modules
 * @author     Cyntax Technologies Dev Team
 * @copyright  (c) 2009-2012 Cyntax Technologies
 * @license    http://code.cyntax.com/licenses/cyntax-open-technology
 */
class Model_Site extends Model
{
	// loads all configuration items from table
	public function load()
	{	
		return DB::select()
			->from('via_site_setting')
			->as_object()
			->execute()
			->as_array('name', 'value', 'title', 'section');
	}
	
	// add a new configuration item
	public function add($name, $value)
	{
		try {
			$results = DB::insert('via_site_setting',
					array('name', 'value', 'title', 'section')
				)
				->values(array($name, $value))
				->execute();
			
			return $results;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	// set value for a single configuration item
	public function set($name, $value, $section,$title)
	{
		try {
			$data = array(
				'value' => $value,
				'section' => $section,
				'title' => $title,
			);
			
			$result = DB::update('via_site_setting')
				->set($data)
				->where('name', '=', $name)
				->execute();
	
			return $result;
		}
		catch(Exception $e)
		{
			return false;
		}
	}
	
	// retrieve a single configuration item
	public function get($name)
	{
		$results = DB::select()
			->from('via_site_setting')
			->where('name', '=', $name)
			->as_object()
			->execute();

		return count($results) > 0 ? $results : NULL;
	}

	public function section($id){

		return DB::select()
			->from('via_site_setting')
			->where('section', '=', $id)
			->as_object()
			->execute();

	}
}
// End of Model Settings