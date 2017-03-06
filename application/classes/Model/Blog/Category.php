<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Blog_Category extends ORM{
	
	protected $_table_name = 'via_blog_category';
	protected $_primary_key = 'url';

	protected $_has_many = array(
		'articles' => array(
			'model'       => 'Blog_Article',
			'far_key'     => 'url',
			'foreign_key' => 'category_url'
		)
	);

	public function change_key($key){
		$this->_primary_key = $key;
	}

	public function where_soft(){
		return $this->where('deleted_at','=',null);
	}

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function view($key){
		return $this->where('view','=',$key);
	}

	public function lang($lang){
		return $this->where('lang','=',$lang);
	}

	public function parent($parent = 0){
		return $this->where('parent_id','=',$parent);
	}

	public function categories($lang,$parent=0){
		return $this->where('lang', '=', $lang)
			->and_where('deleted_at','=',null)
			->and_where('parent_id','=',$parent)
			->order_by('sort','ASC')
			->find_all();
	}

	public function get_category_option($category_option = array(),$lang='ru',$current=''){

		$list = '';
		$item = array();

		if(count($category_option)){
			$dash = ' - ';
		}else{
			$dash = '';
			$category_option = $this->categories($lang,0);
		}

		foreach($category_option as $category){

			$children = $this->categories($category->lang,$category->id);

			if(count($children) > 0){
				$item['get_children'] = $this->get_category_option($children,$category->lang,$current);
			}

			$item['id'] = $category->id;
			$item['url'] = $category->url;
			$item['title'] = $category->title;
			$item['dash'] = $dash;
			$item['parents'] = $children;
			$item['current'] = $current;

			$list .= View::factory('/admin/blog/category_option')
				->bind('item', $item);

			$dash .= $dash;

		}

		return $list;
	}

	public static function check_url($value, $validation, $field, $lang)
	{
		$page = ORM::factory('Blog_Category')->where('url','=',$value)->where('lang','=',$lang)->find();

		if($page->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_url'));
		}
	}
}