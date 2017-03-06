<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Mail_Letter extends ORM{
	
	protected $_table_name = 'via_mail_letter';

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

	protected $_belongs_to = array(
		'folder'  => array(
			'model'       => 'Mail_Folder',
			'foreign_key' => 'folder_id',
		)
	);
}