<?php defined('SYSPATH') or die('No direct script access.');
 
class Model_Mail_Folder extends ORM{
	
	protected $_table_name = 'via_mail_folder';

	public function soft_delete(){
		return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
	}

}