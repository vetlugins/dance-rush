<?php defined('SYSPATH') or die('No direct script access.');

class RemovePhotoInUser extends Migration
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

    // $this->add_column('table_name', 'column_name', array('datetime', 'default' => NULL));
    $this->remove_column('via_users', 'photo');
  }

  public function down()
  {
    // $this->drop_table('table_name');

    $this->remove_column('via_users', 'photo');
  }
}