<?php

require_once(dirname(__FILE__).'/JsonCoder.php');
require_once(dirname(__FILE__).'/XmlCoder.php');

class CoderFactory
{
    public static function createCoder($coderType) {
        if ($coderType == 'json')
            return new JsonCoder();
        else if ($coderType == 'xml')
            return new XmlCoder();
        return nil;
    }
}