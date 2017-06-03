<?php defined('SYSPATH') or die('No direct script access.');

class AddNewFieldParams extends Migration
{
  public function up()
  {
    // $this->create_table
    // (
    //   'table_name',
    //   array
    //   (
    //     'updated_at'          => array('datetime'),
    //     'created_at'          => array('datetime'),
    //   )
    // );

    $this->add_column('via_params', 'deleted_at', array('datetime', 'default' => NULL));
    $this->add_column('via_params', 'type', array('string[255]'));
  }

  public function down()
  {
    // $this->drop_table('table_name');

     $this->remove_column('via_params', 'type');
     $this->remove_column('via_params', 'deleted_at');
  }
}