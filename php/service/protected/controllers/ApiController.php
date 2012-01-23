<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/Factory.php');
include_once('ResourceController.php');
include_once('ServiceController.php');

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
        $controller = ApiControllerFactory::factory()->createObject($controllerName);
        if (is_null($controller) || !isset($controller)) {
            die('ApiController: invalid controller name.');
        }
        
        if (!method_exists($controller, $method)) {
            die('ApiController: controller have not the method with specified name.');
        }
        
        $controller->$method();
    }
}