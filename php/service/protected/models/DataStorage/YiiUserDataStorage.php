<?php
/**
 * Created by JetBrains PhpStorm.
 * User: sshkrabak
 * Date: 9/10/12
 * Time: 11:26 PM
 * To change this template use File | Settings | File Templates.
 */

include_once(__CORE_DIR__.'/model/User.php');
include_once(__CORE_DIR__.'/model/DataStorage/AbstractDataStorage.php');

class YiiUserDataStorage implements AbstractDataStorage
{
    public function save($coreUserModel)
    {
        $model = ARUser::model();
        $transaction = $model->getDbConnection()->beginTransaction();

        try
        {
            if (isset($coreUserModel->id))
                $user = $model->findByPk($coreUserModel->id);

            if (!isset($user) || is_null($user))
                $user = new ARUser();

            $user->name = $coreUserModel->name;
            $user->flags = $coreUserModel->flags;
            $user->email = $coreUserModel->email;
            $user->login = $coreUserModel->login;

            if (isset($coreUserModel->password) && strlen($coreUserModel->password) > 0)
                $user->password = md5(md5($coreUserModel->password));

            if (!$user->save())
                throw new Exception('Could not save USER');
            
            $transaction->commit();
        }
        catch (Exception $e)
        {
            $transaction->rollback();
            throw $e;
        }
    }

    public function remove($coreUserModel)
    {
        return ARUser::model()->deleteByPk($coreUserModel->id);
    }

    public function decodeResponse($data)
    {
        $json = new CJSON();
        return $json->decode($data);
    }
}
