<?php

interface ResponseBuilder  {
    
    public function makeResponseError($errorType);
    
    public function addResource($resource);
    
    public function makeResponse();
    
    public function printResponse();
}

?>