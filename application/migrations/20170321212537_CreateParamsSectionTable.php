<?php defined('SYSPATH') or die('No direct script access.');

class CreateParamsSectionTable extends Migration
{
  public function up()
  {
     $this->create_table
     (
       'via_params_section',
       array
       (
           'title'               => array('string[255]'),
           'updated_at'          => array('datetime'),
           'created_at'          => array('datetime'),
       )
     );

    // $this->add_column('table_name', 'column_name', array('datetime', 'default' => NULL));
  }

  public function down()
  {
     $this->drop_table('via_params_section');

    // $this->remove_column('table_name', 'column_name');
  }
}