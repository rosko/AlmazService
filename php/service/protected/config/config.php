<?php

return array(
    'defaultController'=>'api',
    
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),
    
    'components'=>array(
        'db'=>array(
            'class'=>'CDbConnection',
            'connectionString'=>'mysql:host=127.0.0.1;dbname=resource_manager',
            'username'=>'root',
            'password'=>'',
            'charset'=>'utf8',
        ),
        
        'urlManager'=>array(
            'urlFormat'=>'path',
            'rules'=>array(
                // REST URI format
                array('api/index', 'pattern'=>'api/<controller:\w+>/index.<format:\w+>', 'verb'=>'GET'),
                array('api/list', 'pattern'=>'api/<controller:\w+>/<type:\w+>.<format:\w+>', 'verb'=>'GET'),
                array('api/view', 'pattern'=>'api/<controller:\w+>/<type:\w+>/<id:\d+>.<format:\w+>', 'verb'=>'GET'),
                array('api/update', 'pattern'=>'api/<controller:\w+>/<type:\w+>/<id:\d+>.<format:\w+>', 'verb'=>'POST'), //PUT
                array('api/delete', 'pattern'=>'api/<controller:\w+>/<type:\w+>/<id:\d+>.<format:\w+>', 'verb'=>'DELETE'),
                array('api/create', 'pattern'=>'api/<controller:\w+>/<type:\w+>.<format:\w+>', 'verb'=>'POST'),
                
                // General
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
    ),
    
);