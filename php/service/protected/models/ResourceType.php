<?php

class ResourceType extends CActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'ResourceType';
    }
    
    public function relations() {
        return array(
            'meta' => array(self::HAS_MANY, 'ResourceTypeMetas', 'resource_type_id'),
        );
    }
}