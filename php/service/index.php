<?php

require_once(dirname(__FILE__) . './../vendors/yii-1.1.8/framework/yii.php');

$app = Yii::createWebApplication(dirname(__FILE__).'/protected/config/config.php');
$app->run();
