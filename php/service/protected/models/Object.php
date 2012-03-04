<?php

class CoreObject extends CActiveRecord {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function encodeWithCoder($coder) {
        $attrs = $this->getAttributes();
        
        $properties = array();
        foreach ($this->metas as $meta) {
            $property = $meta->meta->getAttributes();
            $property['value'] = $meta->meta_value;
            $properties[] = $property;
            
        }
        $attrs['property'] = $properties;
        
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
            'metas' => array(self::HAS_MANY, 'ObjectMetaData', 'object_id'),
        );
    }
}