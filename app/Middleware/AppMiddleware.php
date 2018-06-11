<?php

namespace App\Middleware;

use WorkerF\Http\MiddlewareInterface;
use WorkerF\Http\Requests;

class AppMiddleware implements MiddlewareInterface
{
    public function handle(Requests $request)
    {
        // do something
        // if you want to stop middleware flow, return a Closure 
        // or return Route::redirect('your_path', $params)
        return $request;
    }
}
