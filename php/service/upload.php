<?php

require_once(dirname(__FILE__) . './../vendors/yii-1.1.8/framework/yii.php');
include_once(dirname(__FILE__).'/../admin/protected/service/FileUploader.php');

error_reporting(0);

try
{
    if (!FileUploader::hasFile('xfile'))
        throw new Exception();

    $filename = $_POST['xfilename'];
    if (!isset($filename))
        $filename = 'test_'.rand(0, 10000);

    $info = pathinfo($filename);


    $filePath = FileUploader::uploadFileLocal('xfile', $info['basename']);
    if ($filePath == null)
        throw new Exception();

    echo $filePath;
}
catch (Exception $e)
{
    echo "ERROR";
}