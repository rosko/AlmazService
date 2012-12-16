<?php

include_once(dirname(__FILE__).'/../../../core/http/HttpRequest.php');
include_once(dirname(__FILE__).'/../../../core/model/Finder/FinderFactory.php');

class RemoteResourceServiceImpl
{
    const API_RESOURCE_BASE_URL = '/index.php/api/resource';
    const API_ENTITY_BASE_URL = '/index.php/api/service';
    const API_USER_BASE_URL = '/index.php/api/users';
    
    const JSON_RESPONSE_FORMAT = 'json';
    const XML_RESPONSE_FORMAT = 'xml';
    
    private $service_url = null;
    private $format = null;
    
    public function __construct($service_url) {
        $this->service_url = $service_url;
        $this->format = RemoteResourceServiceImpl::JSON_RESPONSE_FORMAT;
    }
    
    public function getResourceTypeList($type) {
        $req = new HttpRequest();
        $req->setUrl($this->makeResourceApiUrl('/'.$type));
        
        $response = $req->perform();
        
        $items = array();
        if (strlen($response) > 0) {
            $coder = new CJSON();
            $items = $coder->decode($response);
            
            //check for error
        }
        
        return $items;
    }
    
    public function getResourceTypeById($id) {
        $req = new HttpRequest();
        $req->setUrl($this->makeResourceApiUrl('/images/'.$id));
        
        return $req->perform();
    }
    
    public function getEntityTypeList() {
        $req = new HttpRequest();
        $req->setUrl($this->makeEntitiesApiUrl('/index'));
        $response = $req->perform();
        
        $items = array();
        if (strlen($response) > 0) {
            $coder = new CJSON();
            $items = $coder->decode($response);
            
            //check for error
        }
        
        return $items;
    }
    
    public function getEntityList($type) {
        $finder = FinderFactory::createFinderWithType($type);
        if ($finder === null)
            throw new Exception('Invalid type');
        
        $list = $finder->findAll();
        
        return $list;
    }
    
    public function getEntityById($type, $id) {
        $finder = FinderFactory::createFinderWithType($type);
        if ($finder === null)
            throw Exception('Invalid type');
        
        $object = $finder->findById($id);
        
        return $object;
    }
    
    public function saveEntity($type, $values, $id=0) {
        $coder = new CJSON();
        $data = $coder->encode($values);
        
        $req = new HttpRequest();
        if ($id == 0) {
            $req->setUrl($this->makeEntitiesApiUrl('/'.$type));
            $req->setParam('data', $data);
            $req->setParam('type', $type);
            $req->setMethod('POST');
        } else {
            $req->setUrl($this->makeEntitiesApiUrl('/'.$type.'/'.$id));
            $req->setParam('data', $data);
            $req->setMethod('POST');
        }
        
        $resp = $req->perform();
        return $coder->decode($resp);
    }
    
    public function removeEntity($type, $id) {
        $req = new HttpRequest();
        $req->setUrl($this->makeEntitiesApiUrl('/'.$type.'/'.$id));
        $req->setMethod('DELETE');
        
        $resp = $req->perform();
        echo $resp;
    }
    
    public function saveResource($type, $resource) {
        $coder = new CJSON();
        $data = $coder->encode($resource);
        
        $url = $this->makeResourceApiUrl('/'.$type);
//        die($url);
        
        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setParam('data', $data);
        $req->setParam('type', $type);
        $req->setMethod('POST');
        $resp = $req->perform();
        
        die($resp);
    }

    public function uploadFile($filePath, $fileName) {
        $url = $this->makeUploadApiUrl('/');
        
        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setParam('xfile', "@".$filePath);
        $req->setParam('xfilename', $fileName);
        $req->setMethod('POST');

        return $req->perform();
    }

    /*
     * Application API
     */

    public function getApplicationList()
    {
        //$url = $this->makeServiceURL(self::API_USER_BASE_URL, '/user');

        $url = $this->service_url.'/index.php/api/apps/app.json'; // Debug

        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setMethod('GET');
        $response = $req->perform();

        $coder = new CJSON();
        $items = $coder->decode($response);

        return $items;
    }

    /*
     * User API
     */

    public function getUserList() {
        $url = $this->makeServiceURL(self::API_USER_BASE_URL, '/user');

        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setMethod('GET');
        $response = $req->perform();

        $coder = new CJSON();
        $items = $coder->decode($response);
        
        return $items;
    }

    public function getUser($id) {
        $url = $this->makeServiceURL(self::API_USER_BASE_URL, '/user/'.$id);

        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setMethod('GET');
        return $req->perform();
    }

    public function saveUser($id, $user) {
        $coder = new CJSON();
        $data = $coder->encode($user);

        $api = '/user';
        if ($id != 0)
            $api .= '/'.$id;
        $url = $this->makeServiceURL(self::API_USER_BASE_URL, $api);

        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setMethod('POST');
        return $req->perform();
    }

    public function removeUser($id) {
        $url = $this->makeServiceURL(self::API_USER_BASE_URL, '/user/'.$id);

        $req = new HttpRequest();
        $req->setUrl($url);
        $req->setMethod('DELETE');
        return $req->perform();
    }

    // ---------------------------------------------------------------------------
    //
    // Private functions
    //
    // ---------------------------------------------------------------------------

    private function makeServiceURL($base, $api = null) {
        $url = $this->service_url . $base;
        if (!is_null($api))
            $url .= $api;
        return ($url . '.' . $this->format);
    }

    private function makeResourceApiUrl($api) {
        return $this->makeServiceURL(self::API_RESOURCE_BASE_URL, $api);
    }

    private function makeUploadApiUrl($api) {
        return $this->service_url . '/upload';
    }
    
    private function makeEntitiesApiUrl($api) {
        return $this->makeServiceURL(self::API_ENTITY_BASE_URL, $api);
    }
}