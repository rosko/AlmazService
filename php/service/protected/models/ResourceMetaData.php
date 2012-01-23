<?php

include_once dirname(__FILE__).'/../core/ICoder.php';

class ResourceMetaData extends CActiveRecord implements ICoder {
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
        return 'ResourceMetaData';
    }
    
    public function relations() {
        return array(
            'resource' => array(self::BELONGS_TO, 'Resource', 'resource_id'),
            'metadata' => array(self::BELONGS_TO, 'MetaDataKey', 'meta_key_id'),
        );
    }
}