<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WisataController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});

Route::get('/auth', [AdminController::class, 'index']);

Route::prefix('wisata')->group(function () {
    $controller = WisataController::class;
    Route::get('/', [$controller, 'index']);
    Route::post('/create', [$controller, 'create']);
    Route::get('/create', [$controller, 'formInput']);
    Route::get('/list', [$controller, 'list']);
    Route::get('/detail/{id}', [$controller, 'detail']);
    Route::put('/detail/{id}', [$controller, 'update']);
    Route::get('/delete/{id}', [$controller, 'delete']);
});

Route::prefix('user')->group(function () {
    $controller = UserController::class;
    Route::get('/', [$controller, 'index']);
});
