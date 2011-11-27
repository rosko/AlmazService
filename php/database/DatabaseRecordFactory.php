<?php

include_once 'model/Resource.php';
include_once 'model/AccessRights.php';
include_once 'model/ClientApplication.php';
include_once 'model/ResourceMetaData.php';
include_once 'model/ResourceObject.php';
include_once 'model/ResourceObjectMetaData.php';
include_once 'model/TextObject.php';

class DatabaseRecordFactory {
    public static function createRecord($type) {
        if (strcmp($type, "AccessRights"))
            return new AccessRights();
        else if (strcmp($type, "ClientApplication"))
            return new ClientApplication();
        else if (strcmp($type, "Resource"))
            return new Resource();
        else if (strcmp($type, "ResourceMetaData"))
            return new ResourceMetaData();
        else if (strcmp($type, "ResourceObject"))
            return new ResourceObject();
        else if (strcmp($type, "ResourceObjectMetaData"))
            return new ResourceObjectMetaData();
        else if (strcmp($type, "TextObject"))
            return new TextObject();
        return false;
    }
}

?>