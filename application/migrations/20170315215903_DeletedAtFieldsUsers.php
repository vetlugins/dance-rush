<?php defined('SYSPATH') or die('No direct script access.');

class DeletedAtFieldsUsers extends Migration
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

    $this->add_column('via_users', 'deleted_at', array('timestamp'=>'NULL', 'default' => 'NULL'));
  }

  public function down()
  {
    // $this->drop_table('table_name');

    // $this->remove_column('table_name', 'column_name');
  }
}