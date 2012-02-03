<?php

class DataModel
{
    const INVALID_ID = 0;
    
    /* ResourceType object id */
    public $id = DataModel::INVALID_ID;
    
    public function getAttributes() {
        return array('id'=>$this->id);
    }
    
    public function setAttributes($attr) {
        $this->id = $attr['id'];
    }
    
    public function getFields() {
        return array(
            array(
                'attribute'=>'id', 'label'=>'ID', 'type'=>'integer',
            ),
        );
    }
}