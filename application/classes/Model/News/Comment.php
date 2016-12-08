<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_News_Comment extends ORM{
	
	protected $_table_name = 'via_news_comments';

	protected $_belongs_to  = array(
		'news' => array('model' => 'News_Items','foreign_key' => 'post_id', )
	);

	public function where_soft(){
		return $this->where('deleted_at','=',null);
	}
}