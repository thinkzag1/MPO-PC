<?php

return [
    'default-connection' => 'concrete',
    'connections' => [
        'concrete' => [
            'driver' => 'c5_pdo_mysql',
            'server' => 'localhost',
            'database' => 'admin_mpo',
            'username' => 'admin_mpo',
            'password' => 'production1',
            'charset' => 'utf8',
        ],
    ],
];
