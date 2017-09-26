<?php

namespace App\Models;

use App\Models\Model;

class Test extends Model
{
    public function getData()
    {
        return '<h1>Hello, welcome to WorkerA</h1>';
    }
}
