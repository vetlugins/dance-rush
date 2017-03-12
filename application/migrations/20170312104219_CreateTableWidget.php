<?php defined('SYSPATH') or die('No direct script access.');

class CreateTableWidget extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'via_widgets_admin',
       array
       (
            'title' => array('string[255]'),
            'description' => array('text'),
            'view' => array('integer'),
            'updated_at'          => array('timestamp'),
            'created_at'          => array('timestamp'),
            'deleted_at'          => array('timestamp'),
       )
     );

     //$this->add_column('table_name', 'column_name', array('datetime', 'default' => NULL));
  }

  public function down()
  {
     $this->drop_table('via_widgets_admin');

     //$this->remove_column('table_name', 'column_name');
  }
}