<?php

include_once 'Factory.php';

class ObjectCodingFactory extends Factory {
    public function __construct() {
        parent::registerType("xml", "CJSON");
        parent::registerType("json", "CJSON");
    }
}