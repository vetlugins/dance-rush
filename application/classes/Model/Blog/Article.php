<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Blog_Article extends ORM{
	
	protected $_table_name = 'via_blog_article';

	protected $_belongs_to = array(
		'author'  => array(
			'model'       => 'Auth_User',
			'foreign_key' => 'user_created',
		),
		'category'  => array(
			'model'       => 'Blog_Category',
			'foreign_key' => 'category_url',
		)
	);

	public function cover(){
		$cover = ORM::factory('Covers')->where('object_type','=','blog')->and_where('object_id','=',$this->id)->and_where('coverable','=',1)->find();
		if($cover->loaded()){
			return $cover->name;
		}else{
			return $cover = '';
		}
	}

	public function change_key($key){
		$this->_primary_key = $key;
	}

	public function where_soft(){
		return $this->where('deleted_at','=',null);
	}

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	public function lang($lang){
		return $this->where('lang', '=', $lang);
	}



	public function article($url,$lang){

		$article = $this->where('lang', '=', $lang)
			->where('url', '=', $url)
			->where_soft()
			->find();

		$views = $article->views + 1;

		$article->set('views',$views)->update();

		return $article;
	}

	public static function check_url($value, $validation, $field, $lang)
	{
		$page = ORM::factory('Blog_Article')->where('url','=',$value)->where('lang','=',$lang)->find();

		if($page->loaded())
		{
			$validation->error($field, Kohana::message('validation', 'check_url'));
		}
	}
}