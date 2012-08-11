<?php

// const YII_DEBUG = true;
error_reporting(E_ERROR);

require_once(dirname(__FILE__) . './../vendors/yii-1.1.8/framework/yii.php');

$app = Yii::createWebApplication(dirname(__FILE__).'/protected/config/config.php');
$app->run();
