<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::controller(App\Http\Controllers\GroupController::class)->prefix('groups')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{group}', 'show');
    Route::put('/{group}', 'update');
    Route::delete('/{group}', 'destroy');
});

Route::controller(App\Http\Controllers\MenuController::class)->prefix('menus')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/listing', 'listing');
    Route::get('/{menu}', 'show');
    Route::put('/{menu}', 'update');
    Route::delete('/{menu}', 'destroy');
});

Route::controller(App\Http\Controllers\SubMenuController::class)->prefix('sub-menus')->group(function () {
    Route::get('/', 'index');
    Route::post('/', 'store');
    Route::get('/{sub_menu}', 'show');
    Route::put('/{sub_menu}', 'update');
    Route::delete('/{sub_menu}', 'destroy');
});