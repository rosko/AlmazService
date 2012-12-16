<?php

require_once(dirname(__FILE__) . '/DataModel.php');

class ClientApp extends DataModel
{
    public $name;
    public $devkey;
    public $company;
    public $email;
    public $weblink;
    public $descr;

    public function __toString() {
        return "ClientApplication";
    }

    public function getFields() {
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'name', 'label'=>'Name', 'type'=>'string');
        $fields[] = array('attribute'=>'email', 'label'=>'Email', 'type'=>'string');
        $fields[] = array('attribute'=>'company', 'label'=>'Company', 'type'=>'string');
        $fields[] = array('attribute'=>'devkey', 'label'=>'Developer Key', 'type'=>'string', 'readonly'=>true);
        $fields[] = array('attribute'=>'weblink', 'label'=>'Web', 'type'=>'string');
        $fields[] = array('attribute'=>'descr', 'label'=>'Description', 'type'=>'string');
        return $fields;
    }
}