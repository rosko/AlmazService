<?php

class Resource extends CActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'Resource';
    }
    
    public function relations() {
        return array(
            'type' => array(self::BELONGS_TO, 'ResourceType', 'type_id'),
            'meta' => array(self::HAS_MANY, 'ResourceMetaData', 'resource_id'),
            'objects' => array(self::HAS_MANY, 'Object', 'resource_id'),
        );
    }
}