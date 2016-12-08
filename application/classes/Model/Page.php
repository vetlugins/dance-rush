<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Page extends ORM{
	
	protected $_table_name = 'via_page';

	protected  $_belongs_to = array(
		'menu'           => array(
			'model'         => 'Menu',
			'foreign_key'   => 'menu_id',
		),
	);

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function getAllPages($lang,$parent = 0){
		return $this->where('lang', '=', $lang)
			->and_where('deleted_at','=',null)
			->and_where('parent_id','=',$parent)
			->order_by('sort','ASC')
			->find_all();
	}

	public function get_page_option($pages_option = array(),$lang='ru',$current=0){

		$list = '';
		$item = array();

		if(!empty($pages_option)){
			$dash = ' - ';
		}else{
			$dash = '';
			$pages_option = $this->getAllPages($lang,0);
		}

		foreach($pages_option as $page){

			$children = $this->getAllPages($page->lang,$page->id);

			if(count($children) > 0){
				$item['get_children'] = $this->get_page_option($children,$page->lang,$current);
			}

			$item['id'] = $page->id;
			$item['title'] = $page->title;
			$item['dash'] = $dash;
			$item['parents'] = $children;
			$item['current'] = $current;

			$list .= View::factory('/admin/pages/page/list_option')
				->bind('item', $item);

			$dash .= $dash;

		}

		return $list;
	}
}