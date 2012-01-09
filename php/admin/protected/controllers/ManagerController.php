<?php

include_once(dirname(__FILE__).'/../service/ResourceService.php');

class ManagerController extends CController {
    public $str;
    
    public function actionIndex() {
        $service = new ResourceService('resourceservice.local');
        $this->str = $service->getResourceTypeById(3);
        
        $this->render('index');
    }
}