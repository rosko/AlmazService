<?php

include_once 'Factory.php';
include_once 'controllers/ResourceController.php';

class ResourceControllerFactory extends Factory {
    public function __construct() {
        parent::registerType("resource", "ResourceController");
    }
}

?>