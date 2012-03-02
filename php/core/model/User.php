<?php

/*
 High level model class.
 Current class describe the resource type meta
*/

require_once(dirname(__FILE__) . '/DataModel.php');

class User extends DataModel
{
    public $flags;
    public $name;
    public $email;
    public $login;
    public $password;

    public function __toString() {
        return "User";
    }
    
    public function getFields() {
        $fields = parent::getFields();
        $fields[] = array('attribute'=>'name', 'label'=>'Name', 'type'=>'string');
        $fields[] = array('attribute'=>'email', 'label'=>'Email', 'type'=>'string');
        $fields[] = array('attribute'=>'login', 'label'=>'Login', 'type'=>'string');
        $fields[] = array('attribute'=>'password', 'label'=>'Password', 'type'=>'string');
        return $fields;
    }
}