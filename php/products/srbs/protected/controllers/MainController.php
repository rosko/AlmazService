<?php

include_once(dirname(__FILE__).'/../../../../core/model/Finder/FinderFactory.php');
include_once(dirname(__FILE__).'/../../../../core/model/DataModelFactory.php');

class MainController extends CController
{
    /*
    Actions method implementation. Method name must contain page name and 'action' string
    as a prefix
    */
    public function actionIndex()
    {
        $this->render('index');
    }
    
    public function actionAbout()
    {
        $this->render('about');
    }
    
    public function actionResources()
    {
        $resourceFinder = FinderFactory::createFinderWithType('resource');
        if (is_null($resourceFinder))
            die('Error: invalid finder');
        
        $resourceFinder->setType('image');
        $audioResources = $resourceFinder->findAll();
        
        if (is_null($audioResources) || !isset($audioResources))
            $audioResources = array();
        
        $this->render('resources', array('data' => $audioResources));
    }
}