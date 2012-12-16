<?php

include_once(__SERVICE_SRC_DIR__ . '/models/ARUser.php');
include_once(__SERVICE_SRC_DIR__ . '/models/DataStorage/YiiUserDataStorage.php');

//YiiUserDataStorage
class UserController
{
    public function actionIndex()
    {
    }
    
    public function actionView()
    {
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);
        
        $id = Parameters::get('id');
        $result = ARUser::model()->findByPk($id);

        if (is_null($result))
            throw new APIException('Invalid ID value', APIResponseCode::API_INVALID_ID);

        $coder = new CJSON();
        $response = $coder->encode($result);

        echo $response;
    }
    
    public function actionList()
    {
        $result = ARUser::model()->findAll();
        $coder = new CJSON();

        echo $coder->encode($result);
    }
    
    public function actionCreate()
    {
        $storage = new YiiUserDataStorage();

        if (is_null($storage))
            throw new APIException('Could not create data storage', APIResponseCode::API_INVALID_METHOD_PARAMS);

        try
        {
            $obj = new User();
            $data = Parameters::getRaw('data', 'post');

            $attr = $storage->decodeResponse($data);
            $obj->setAttributes($attr);
            
            $storage->save($obj);
        }
        catch (Exception $e)
        {
            throw new APIException('Can not save resource object', APIResponseCode::API_SHEMA_CREATE_ERROR);
        }
    }
    
    public function actionUpdate()
    {
        die("update");
    }
    
    public function actionDelete()
    {
        die("delete");
    }
}
