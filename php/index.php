<?php

include_once 'controllers/ResourceController.php';
include_once 'controllers/ResourceControllerFactory.php';

$resourceType = $_GET['resource_type'];
if (isset($resourceType) && strlen($resourceType) > 0)
{
    $controller = ResourceControllerFactory::createController($resourceType);
    $controller->performAction();
}
else
{
//    ErrorController::showError(405);
}

// function getAudioResource() {}
// 
// $controller = ControllerFactory::createController($type);

/*

resource_type = [news, images, video, audio, ...]
action = [get, list, search, ...]
response_type = [json, xml]
and other params as url get params


/resource/news/get.json
/resource/images/get.json
/resource/video/get.json
/resource/audio/get.json?id=21312312
/resource/audio/get.json?from=21312&count=14
/resource/audio/list.json
/resource/audio/search.json?name=werwe&length=32234&int=34232
*/

// Model api example
/*
function resourceById($type, $id) {
    $responseBuilder = ResponseBuilderFactory::responseBuilder('json');
    
    if (!DatabaseManager::manager()->validateResourceType($type))
        return $responseBuilder->makeErrorResponse(INVALID_TYPE_ERROR);
    
    $record = DatabaseManager::manager()->getResourceById($type, $id);
    if (!$record)
        return $responseBuilder->makeErrorResponse(INVALID_ARG_ERROR);
    
    $responseBuilder->addRecord($record);
    
    return $responseBuilder->makeResponse();
}

function resources($type, $from, $to) {
    $responseBuilder = ResponseBuilderFactory::responseBuilder('json');
    
    if (!DatabaseManager::manager()->validateResourceType($type))
        return $responseBuilder->makeErrorResponse(INVALID_TYPE_ERROR);
    
    $count = DatabaseManager::manager()->getResourcesCount($type);
    if ($count <= $from)
        return $responseBuilder->makeErrorResponse(INVALID_ARG_ERROR);
    
    $resources = DatabaseManager::manager()->getResources($type, $from, $to);
    foreach ($resources as $oneResource) {
        $responseBuilder->addRecord($oneResource);
    }
    
    return $responseBuilder->makeResponse();
}
*/

?>
