<?php

const YII_DEBUG = true;
error_reporting(E_ERROR);

define("__CORE_DIR__", dirname(dirname(__FILE__)).'/core' );
define("__SRC_DIR__", dirname(__FILE__).'/protected');

require_once(dirname(__FILE__) . './../vendors/yii-1.1.8/framework/yii.php');

$app = Yii::createWebApplication(__SRC_DIR__.'/config/config.php');
$app->run();
