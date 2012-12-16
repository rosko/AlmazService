<?php

include_once(dirname(__FILE__).'/../utils/Parameters.php');
include_once(dirname(__FILE__).'/../utils/Factory.php');
include_once(dirname(__FILE__).'/../utils/ObjectCodingFactory.php');
include_once(dirname(__FILE__).'/../exception/APIException.php');
include_once(dirname(__FILE__).'/APIResponseCode.php');
include_once(dirname(__FILE__).'/ResourceController.php');
include_once(dirname(__FILE__).'/ServiceController.php');
include_once(dirname(__FILE__).'/UserController.php');
include_once(dirname(__FILE__).'/ClientAppController.php');

/*
 * API controller. It's a main entry point to all actions.
 * Creates controller and dispatches callee method to the new controller.
 * All supported controller must be registered in controller factory (see getFactory method).
 */
class ApiController extends CController
{
    private $factory = NULL;

    /*
     * Returns controller factory. Creates and initialize factory if factory is NULL.
     */
    public function getFactory()
    {
        if ($this->factory == NULL)
        {
            $this->factory = Factory::factory();
            $this->factory->registerType('resource', 'ResourceController');
            $this->factory->registerType('service', 'ServiceController');
            $this->factory->registerType('users', 'UserController');
            $this->factory->registerType('apps', 'ClientAppController');
        }
        return $this->factory;
    }

    /*
     * Entry point function.
     *
     * This method is called from CController only if desired action not found.
     * Action name passed as actionID parameter.
     * Dispatch this action to the destination controller.
     */
    public function missingAction($actionID)
    {
        $controller = Parameters::get('controller');
        $method = $this->createActionName($actionID);

        Yii::trace('call api method: '.$controller.'.'.$method);
        
        $this->dispatchCall($controller, $method);
    }

    /*
     * Create controller object with $controllerName class name.
     * Call $method if it exists.
     * Throws exception if controller is invalid or method not exists.
     */
    private function dispatchCall($controllerName, $method)
    {
        $format = Parameters::hasParam('format') ? Parameters::get('format') : 'json';
        
        try
        {
            $controller = $this->getFactory()->createObject($controllerName);
            if (is_null($controller) || !isset($controller))
                throw new APIException('Invalid controller name', APIResponseCode::API_INVALID_CLASSNAME);
            
            if (!method_exists($controller, $method))
                throw new APIException('Controller have not the method with specified name', APIResponseCode::API_INVALID_METHOD);
            
            $controller->$method();
        }
        catch (APIException $ex)
        {
            Yii::trace($ex, 'apps.APIController');

            die($ex->getResponse($format));
        }
    }

    private function createActionName($actionID)
    {
        return 'action'.$actionID;
    }
}