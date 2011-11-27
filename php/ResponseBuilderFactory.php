<?php

include_once 'Factory.php';
include_once 'JsonResponseBuilder.php';
include_once 'XmlResponseBuilder.php';

class ResponseBuilderFactory extends Factory {
    public function __construct() {
        parent::registerType("xml", "XmlResponseBuilder");
        parent::registerType("json", "JsonResponseBuilder");
    }
}

?>