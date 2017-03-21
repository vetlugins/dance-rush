<?php defined('SYSPATH') or die('No direct script access.');

class CreateParamsTable extends Migration
{
  public function up()
  {
     $this->create_table
     (
         'via_params',
         array
         (
            'name'                => array('string[255]'),
            'value'               => array('string[255]'),
            'section_id'          => array('integer'),
            'updated_at'          => array('datetime'),
            'created_at'          => array('datetime'),
         )
      );

    // $this->add_column('table_name', 'column_name', array('datetime', 'default' => NULL));
  }

  public function down()
  {
    $this->drop_table('via_params');

    // $this->remove_column('table_name', 'column_name');
  }
}