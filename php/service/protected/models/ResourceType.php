<?php

include_once dirname(__FILE__).'/../core/ICoder.php';

class ResourceType extends CActiveRecord implements ICoder {
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }
    
    public function encodeWithCoder($coder) {
        $attrs = $this->getAttributes();
        
        $properties = array();
        foreach ($this->metas as $meta) {
            $properties[] = $meta->meta;
        }
        $attrs['property'] = $properties;
        
        return $coder->encode($attrs);
    }
    
    public function decodeWithCoder($coder, $value) {
        $attrs = $coder->decode($value);
        $this->setAttributes($attrs);
    }
    
    public function tableName() {
        return 'ResourceType';
    }
    
    public function relations() {
        return array(
            'metas' => array(self::HAS_MANY, 'ResourceTypeMetas', 'resource_type_id'),
        );
    }
}