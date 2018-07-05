<?php

namespace App\Exceptions;

use WorkerF\Exceptions\ExceptionHandler;

class Handler extends ExceptionHandler
{
    public function handle(\Exception $e)
    {
        return parent::handle($e);
    }
}
