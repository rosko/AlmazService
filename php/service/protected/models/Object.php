<?php

class CoreObject extends CActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function encodeWithCoder($coder) {
        $attrs = $this->getAttributes();
        return $coder->encode($attrs);
    }
    
    public function decodeWithCoder($coder, $value) {
        $attrs = $coder->decode($value);
        $this->setAttributes($attrs);
    }
    
    public function tableName() {
        return 'Object';
    }
    
    public function relations() {
        return array(
            'resource' => array(self::BELONGS_TO, 'Resource', 'resource_id'),
        );
    }
}