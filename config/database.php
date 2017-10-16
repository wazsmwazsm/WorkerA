<?php

return [
    'db_con' => [
        'con1' => [
          'driver'   => 'mysql',
          'host'     => 'localhost',
          'port'     => '3306',
          'user'     => 'username',
          'password' => 'password',
          'dbname'   => 'database',
          'charset'  => 'utf8',
        ],
    ],

    'redis' => [
      'cluster' => FALSE,
      'options' => NULL,
      'rd_con' => [
          'default' => [
              'host'     => '127.0.0.1',
              'password' => NULL,
              'port'     => 6379,
              'database' => 0,
              // 'read_write_timeout' => 0,
          ],
      ]
    ]
];
