<?php

include_once 'JsonResponseBuilder.php';
include_once 'XmlResponseBuilder.php';

class ResponseBuilderFactory {
    public static function responseBuilder($type) {
        if (strcmp($type, "json") == 0)
            return new JsonResponseBuilder();
        else if (strcmp($type, "xml") == 0)
            return new XmlResponseBuilder();
        return false;
    }
}

?>