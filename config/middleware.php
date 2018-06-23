<?php
/*
|--------------------------------------------------------------------------
| Middleware Config
|--------------------------------------------------------------------------
*/
return [
     /*
     |--------------------------------------------------------------------------
     | Global HTTP middlewares
     |--------------------------------------------------------------------------
     |
     | These middleware are run during every request to your application.
     |
     */
    'global' => [
        'App\Middleware\AppMiddleware',
    ],

    /*
     |--------------------------------------------------------------------------
     | Route HTTP middlewares
     |--------------------------------------------------------------------------
     |
     | These middleware may be assigned to groups or used individually when 
     | setting up route.
     |
     */
    'route' => [

    ],
];
