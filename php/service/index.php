<?php

define(YII_DEBUG, true);
define(YII_TRACE_LEVEL, 1);

define("__CORE_DIR__", dirname(dirname(__FILE__)).'/core' );
define("__SERVICE_SRC_DIR__", dirname(__FILE__).'/protected');

error_reporting(E_ALL);
ini_set('display_errors', true);

require_once(dirname(__FILE__) . './../vendors/yii-1.1.8/framework/yii.php');

$app = Yii::createWebApplication(dirname(__FILE__).'/protected/config/config.php');
$app->run();

