<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Page extends ORM{
	
	protected $_table_name = 'via_page';

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function where_soft(){
		return $this->where('deleted_at','=',null);
	}

	public function change_key($key){
		$this->_primary_key = $key;
	}

	public function parent($parent = 0){
		return $this->where('parent_id','=',$parent);
	}

	public function lang($lang = 'ru'){
		return $this->where('lang','=',$lang);
	}


	public function pages($lang,$parent = 0){

		return $this->where('lang', '=', $lang)
			->and_where('deleted_at','=',null)
			->and_where('parent_id','=',$parent)
			->order_by('sort','ASC')
			->find_all();
	}

	public function page($id){
		return $this->where('id', '=', $id)
			->and_where('deleted_at','=',null)
			->find();
	}

	public function get_page_option($pages_option = array(),$lang='ru',$current=0){

		$list = '';
		$item = array();

		if(count($pages_option)){
			$dash = ' - ';
		}else{
			$dash = '';
			$pages_option = $this->pages($lang,0);
		}

		foreach($pages_option as $page){

			$children = $this->pages($page->lang,$page->id);

			if(count($children) > 0){
				$item['get_children'] = $this->get_page_option($children,$page->lang,$current);
			}

			$item['id'] = $page->id;
			$item['title'] = $page->title;
			$item['dash'] = $dash;
			$item['parents'] = $children;
			$item['current'] = $current;

			$list .= View::factory('/admin/pages/list_option')
				->bind('item', $item);

			$dash .= $dash;

		}

		return $list;
	}

	public static function check_url($value, $validation, $field, $lang)
	{
		$page = ORM::factory('Page')->where('url','=',$value)->where('lang','=',$lang)->find();

		if($page->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_url'));
		}
	}

}