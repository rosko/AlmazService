<?php

include_once 'Factory.php';
include_once 'controllers/ResourceController.php';

class ObjectControllerFactory extends Factory {
    public function __construct() {
        parent::registerType("resource", "ResourceController");
//        parent::registerType("service", "ServiceController");
    }
}

?>