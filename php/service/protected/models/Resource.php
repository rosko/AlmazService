<?php

include_once dirname(__FILE__).'/../core/ICoder.php';

class ARResource extends CActiveRecord implements ICoder1 {
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
        return 'Resource';
    }
    
    public function relations() {
        return array(
            'type' => array(self::BELONGS_TO, 'ResourceType', 'type_id'),
            'meta' => array(self::HAS_MANY, 'ResourceMetaData', 'resource_id'),
            'objects' => array(self::HAS_MANY, 'Object', 'resource_id'),
            'applications' => array(self::HAS_MANY, 'Applications', 'resource_id'),
        );
    }
}