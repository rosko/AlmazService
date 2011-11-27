<?php

include_once 'model/ResourceManager.php';
include_once 'ResponseBuilderFactory.php';

class ResourceController {
    const DEFAULT_RESPONSE_TYPE = "json";
    const DEFAULT_FROM = 1;
    const DEFAULT_COUNT = 10;
    
    private $responseBuilder = null;
    private $resourceType = null;
    
    public function __construct() {
        $responseType = $_GET['response_type'];
        if (!isset($responseType))
            $responseType = ResourceController::DEFAULT_RESPONSE_TYPE;
        $this->responseBuilder = ResponseBuilderFactory::factory()->createObject($responseType);
        
        $this->resourceType = $_GET['resource_type'];
        if (!ResourceManager::manager()->validateResourceType($this->resourceType)) {
            die("Invalid type");
        }
    }
    
    public function __destruct() {
        unset($this->responseBuilder);
    }
    
    public function performAction() {
        $action = $_GET['action'];
        
        if (!isset($action) || strlen($action) == 0) {
            $this->responseBuilder->makeResponseError(123, "you must specify action parameter<br/>");
        } else {
            $methodName = 'action'.$action;
            if (!method_exists($this, $methodName))
                $this->responseBuilder->makeResponseError(404, "Method Not Found [".$methodName."]<br/>");
            else
                $this->$methodName();
        }
                
        $this->responseBuilder->makeResponse();
        $this->responseBuilder->printResponse();
    }
    
    public function actionGet() {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            $resource = ResourceManager::manager()->getResourceById($this->resourceType, $id);
            if ($resource)
                $this->responseBuilder->addResource($resource);
            else
                $this->responseBuilder->makeResponseError(2, "Could not find resource with id=".$id);
        } else {
            $from = $_GET['from'];
            $count = $_GET['count'];
            if (!isset($from))
                $from = ResourceController::DEFAULT_FROM;
            if (!isset($count))
                $count = ResourceController::DEFAULT_COUNT;
            
            if ($count < 0)
                $this->responseBuilder->makeResponseError(1, "Count value must be more than 0");
            if ($from < 0)
                $this->responseBuilder->makeResponseError(1, "From value must be more than 0");
            
            $resources = ResourceManager::manager()->getResources($this->resourceType, $from, $count);
            if (count($resource) > 0) {
                foreach ($resources as $oneResource) {
                    $this->responseBuilder->addResource($oneResource);
                }
            }
        }
    }
    
    public function actionSearch() {
        
    }

};

?>