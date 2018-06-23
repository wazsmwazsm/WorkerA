<?php
use WorkerF\Http\Route;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register routes for your application.
| Also, you can make a new route file in this Directory and 
| require it in bootstap/boot.php
|
*/
Route::get('/', "App\Controller\TestController@test");
