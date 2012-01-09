<?php

class Object extends CActiveRecord {
    public static function model($className == __CLASS__) {
        return parent::model($className);
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