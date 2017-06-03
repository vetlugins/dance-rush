<?php

class Model_Base extends ORM{

    public function soft_delete(){
        return $this->set('deleted_at', date('Y-m-d H:i:s'))->update();
    }

    public function where_soft(){
        return $this->where('deleted_at','=',null);
    }

    public function change_key($key){
        $this->_primary_key = $key;
    }

}