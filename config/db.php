<?php
return [ 
    'integle_hui' => [ 
        'class' => 'yii\db\Connection',
        'charset' => 'utf8',
        'tablePrefix' => 'integle_',
        'dsn' => 'mysql:host='.DB_HOST_PREFIX.'write.db.integle.com;dbname=integle_hui',
        'username' => 'integle_w',
        'password' => 'integle@2013',
        'attributes' => [
            PDO::ATTR_TIMEOUT => 10
        ],
        
        'slaveConfig' => [ 
            'charset' => 'utf8',
            'tablePrefix' => 'integle_',
            'username' => 'integle_r',
            'password' => 'integle@2013',
            'attributes' => [ 
                PDO::ATTR_TIMEOUT => 10 
            ] 
        ],
        'slaves' => [ 
            [ 
                'dsn' => 'mysql:host='.DB_HOST_PREFIX.'read.db.integle.com;dbname=integle_hui' 
            ] 
        ] 
    ],
    'pg_platform' => [ 
        'class' => 'yii\db\Connection',
        'charset' => 'utf8',
        'dsn' => 'pgsql:host='.DB_HOST_PREFIX.'pgsql.db.integle.com;port=5432;dbname=platform',
        'username' => 'integle',
        'password' => 'integle@2013' 
    ] 
];
