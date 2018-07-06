<?php

namespace App\Exceptions;

use WorkerF\Exceptions\ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function handle(\Exception $e)
    {
        // you can handle the exception and create response data here
        // if ($e instanceof SomeException) {
        //     // return response    
        //     return [
        //         'status' => 1,
        //         'msg'    => $e->getMessage(),
        //         'data'   => 'something',
        //     ];
        // }

        // default use WorkerF\Exceptions\ExceptionHandler::handle, return default error data
        return parent::handle($e);
    }
}
