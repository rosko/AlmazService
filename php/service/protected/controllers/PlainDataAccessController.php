<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sshkrabak
 * Date: 9/11/12
 * Time: 12:41 AM
 * To change this template use File | Settings | File Templates.
 */

include_once(__SERVICE_SRC_DIR__.'/models/PlainDataAccess.php');

class PlainDataAccessController
{
    private $dataAccessor = NULL;

    public function __construct()
    {
        $this->dataAccessor = new PlainDataAccess();
    }

    public function actionView()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        $type = Parameters::get('type');
        $id = Parameters::get('id');

        $item = $this->dataAccessor->get($type, $id);

        return $item;
    }

    public function actionList()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        $type = Parameters::get('type');

        $dataSet = $this->dataAccessor->getAll($type);

        return $dataSet;
    }

    public function actionCreate()
    {
        if (!Parameters::hasParam('data'))
            throw new APIException('Invalid resource TYPE (parameter name: \'data\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        $type = Parameters::get('type');
        $data = Parameters::getRaw('data', 'post');

        // Should use decoder
        $attributes = $data;

        return $this->dataAccessor->save($type, $attributes);
    }

    public function actionUpdate()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        if (!Parameters::hasParam('data'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'data\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        $type = Parameters::get('type');
        $data = Parameters::getRaw('data', 'post');

        // Should use decoder
        $attributes = $data;

        return $this->dataAccessor->save($type, $attributes);
    }

    public function actionDelete()
    {
        if (!Parameters::hasParam('type'))
            throw new APIException('Invalid resource TYPE (parameter name: \'type\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        if (!Parameters::hasParam('id'))
            throw new APIException('Invalid resource IDENTIFICATOR (parameter name: \'id\')', APIResponseCode::API_INVALID_METHOD_PARAMS);

        $type = Parameters::get('type');
        $id = Parameters::get('id');

        return $this->dataAccessor->delete($type, $id);
    }

    public function actionSearch()
    {
        //Empty method
    }
}
