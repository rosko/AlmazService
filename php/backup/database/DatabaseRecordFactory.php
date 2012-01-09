<?php

include_once 'Factory.php';
include_once 'model/Resource.php';
include_once 'model/ResourceType.php';
include_once 'model/ResourceMetaData.php';
include_once 'model/ResourceObject.php';
include_once 'model/ResourceObjectMetaData.php';
include_once 'model/TextObject.php';
include_once 'model/AccessRights.php';
include_once 'model/ClientApplication.php';

class DatabaseRecordFactory extends Factory {
    public function __construct() {
        parent::registerType("AccessRights", "AccessRights");
        parent::registerType("ClientApplication", "ClientApplication");
        parent::registerType("Resource", "Resource");
        parent::registerType("ResourceType", "ResourceType");
        parent::registerType("ResourceMetaData", "ResourceMetaData");
        parent::registerType("ResourceObject", "ResourceObject");
        parent::registerType("ResourceObjectMetaData", "ResourceObjectMetaData");
        parent::registerType("TextObject", "TextObject");
    }
}

?>