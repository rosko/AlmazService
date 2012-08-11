<?php

include_once dirname(__FILE__).'/../core/ICoder.php';

class ResourceObject extends CActiveRecord implements ICoder1 {
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
        return 'ResourceObject';
    }

    public function relations() {
        return array(
            'resource' => array(self::HAS_ONE, 'Resource', 'resource_id'),
            'object' => array(self::HAS_ONE, 'CoreObject', 'object_id'),
        );
    }
}