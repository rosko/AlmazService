<?php

return array(
    'defaultController' => 'service',
    
    'import' => array(
        'application.models.*',
        'application.components.*',
    ),
    
    'components' => array(
        'db' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=127.0.0.1;dbname=resource_manager',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),
    ),
    
    // 'urlManager' => array(
    //     'urlFormat' => 'path',
    //     'rules' => array(
    //         '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
    //     ),
    // ),
);