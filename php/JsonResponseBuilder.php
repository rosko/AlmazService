<?php

include_once 'ResponseBuilder.php';

class JsonResponseBuilder implements ResponseBuilder {
    private $response = "";
    
    public function makeResponseError($errorType, $errorMsg = '') {
        $this->response .= "Error " . $errorType . ": " . $errorMsg;
    }
    
    public function addResource($resource) {
        
    }
    
    public function makeResponse() {
        
    }
    
    public function printResponse() {
        echo $this->response;
    }
}

?>