<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/Factory.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');
include_once(dirname(__FILE__).'/../exception/APIException.php');
include_once(dirname(__FILE__).'/APIResponseCode.php');
include_once(dirname(__FILE__).'/ResourceController.php');
include_once(dirname(__FILE__).'/ServiceController.php');

class ApiControllerFactory extends Factory {
    public function __construct() {
        parent::registerType("resource", "ResourceController");
        parent::registerType("service", "ServiceController");
    }
}

class ApiController extends CController {
    
    public function actionIndex() {
        $this->dispatchCall(Parameters::get('controller'), __FUNCTION__);
    }
    
    public function actionView() {
        $this->dispatchCall(Parameters::get('controller'), __FUNCTION__);
    }
    
    public function actionList() {
        $this->dispatchCall(Parameters::get('controller'), __FUNCTION__);
    }
    
    public function actionUpdate() {
        $this->dispatchCall(Parameters::get('controller'), __FUNCTION__);
    }
    
    public function actionCreate() {
        $this->dispatchCall(Parameters::get('controller'), __FUNCTION__);
    }
    
    public function actionDelete() {
        $this->dispatchCall(Parameters::get('controller'), __FUNCTION__);
    }
    
    public function actionSearch() {
        $this->dispatchCall(Parameters::get('controller'), __FUNCTION__);
    }
    
    private function dispatchCall($controllerName, $method) {
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        
        try
        {
            $controller = ApiControllerFactory::factory()->createObject($controllerName);
            if (is_null($controller) || !isset($controller))
                throw new APIException('Invalid controller name', APIResponseCode::API_INVALID_CLASSNAME);
            
            if (!method_exists($controller, $method))
                throw new APIException('Controller have not the method with specified name', APIResponseCode::API_INVALID_METHOD);
            
            $controller->$method();
        }
        catch (APIException $ex)
        {
            die($ex->getResponse($format));
        }
    }
}