<?php

class ObjectMetaData extends CActiveRecord {
    public static function model($className == __CLASS__) {
        return parent::model($className);
    }
    
    public function tableName() {
        return 'ObjectMetaData';
    }
    
    public function relations() {
        return array(
            'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
            'metadata' => array(self::BELONGS_TO, 'MetaDataKey', 'meta_key_id'),
        );
    }
}