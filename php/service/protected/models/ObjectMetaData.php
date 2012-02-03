<?php

include_once dirname(__FILE__).'/../core/ICoder.php';

class ObjectMetaData extends CActiveRecord implements ICoder {
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
        return 'ObjectMetaData';
    }
    
    public function relations() {
        return array(
            'object' => array(self::BELONGS_TO, 'Object', 'object_id'),
            'metadata' => array(self::BELONGS_TO, 'MetaDataKey', 'meta_key_id'),
        );
    }
}