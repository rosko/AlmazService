<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sshkrabak
 * Date: 9/10/12
 * Time: 11:04 PM
 * To change this template use File | Settings | File Templates.
 */
 
class ARClientApp extends CActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'ClientApplication';
    }

    public function encodeWithCoder($coder) {
        $attrs = $this->getAttributes();
        return $coder->encode($attrs);
    }

    public function decodeWithCoder($coder, $value) {
        $attrs = $coder->decode($value);
        $this->setAttributes($attrs);
    }

    public function relations()
    {
        return array(
//            'resource' => array(self::BELONGS_TO, 'Resource', 'resource_id'),
//            'application' => array(self::BELONGS_TO, 'ClientApplication', 'client_application_id'),
        );
    }
}
