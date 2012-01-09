<?php

class ResourceMetaData extends CActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'ResourceMetaData';
    }
    
    public function relations() {
        return array(
            'resource' => array(self::BELONGS_TO, 'Resource', 'resource_id'),
            'metadata' => array(self::BELONGS_TO, 'MetaDataKey', 'meta_key_id'),
        );
    }
}