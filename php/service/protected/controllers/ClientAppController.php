<?php

include_once(dirname(__FILE__) . '/../models/ARClientApp.php');

class ClientAppController
{
    public function actionIndex()
    {
    }

    public function actionView()
    {
        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        $id = Parameters::get('id');
        $result = ARClientApp::model()->findByPk($id);

        if (is_null($result))
            throw new APIException('Invalid ID value', APIResponseCode::API_INVALID_ID);

        $coder = new CJSON();
        $response = $coder->encode($result);

        echo $response;
    }

    public function actionList()
    {
        $result = ARClientApp::model()->findAll();
        $coder = new CJSON();
        
        echo $coder->encode($result);
    }

    public function actionCreate() {
        die("create");
    }

    public function actionUpdate() {
        die("update");
    }

    public function actionDelete() {
        die("delete");
    }
}