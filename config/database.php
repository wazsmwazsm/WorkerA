<?php
/*
|--------------------------------------------------------------------------
| Database Config
|--------------------------------------------------------------------------
*/
return [
    /*
    |--------------------------------------------------------------------------
    | Database Connections
    |--------------------------------------------------------------------------
    |
    | Here are database connections setup for your application.
    |
    | All database work in WokerA is done through the PHP PDO facilities
    | so make sure you have the driver for your particular database of
    | choice installed on your machine before you begin development.
    | 
    | Mysql, PostgreSql, Sqlite driver supported right now.
    |
    */
    'db_con' => [
        /*
        'con1' => [ // mysql demo
            'driver'      => 'mysql',
            'host'        => 'localhost',
            'port'        => '3306',
            'user'        => 'username',
            'password'    => 'password',
            'dbname'      => 'database',
            'charset'     => 'utf8',
            'prefix'      => '',
            'timezone'    => '+8:00',
            'collection'  => 'utf8_general_ci',
            // 'strict'      => false,
            // 'unix_socket' => '/var/run/mysqld/mysqld.sock',
            // 'options'     => [],
        ],
        */
        
        /*
        'con2' => [ // postgresql demo
            'driver'           => 'pgsql',
            'host'             => 'localhost',
            'port'             => '5432',
            'user'             => 'username',
            'password'         => 'password',
            'dbname'           => 'database',
            'charset'          => 'utf8',
            'timezone'         => '+8:00',
            'prefix'           => '',
            // 'schema'           => '',
            // 'application_name' => '',
            // 'sslmode'          => 'disable',
            // 'options'          => [],
        ],
        */
        
        /*
        'con3' => [ // sqlite demo
            'driver'  => 'sqlite',
            'dbname'  => 'database.db',
            'prefix'  => '',
            // 'options' => [],
        ],
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Redis Databases
    |--------------------------------------------------------------------------
    |
    | Here is Redis config.
    |
    | The redis in WorkerA is based on predis
    | see more: https://github.com/nrk/predis
    |
    */
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
