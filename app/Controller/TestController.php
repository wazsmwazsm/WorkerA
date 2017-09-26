<?php

namespace App\Controller;
use App\Controller\Controller;
use WorkerF\Http\Requests;
use App\Models\Test;

class TestController extends Controller
{
    public function test(Test $test, Requests $request)
    {
        $rst = $test->getData();

        return $rst;
    }
}
