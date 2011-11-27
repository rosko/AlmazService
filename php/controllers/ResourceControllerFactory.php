<?php

include_once 'controllers/ResourceController.php';

class ResourceControllerFactory {
    public function createController($resourceType) {
        return new ResourceController();
    }
}

?>