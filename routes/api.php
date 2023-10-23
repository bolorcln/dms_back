<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableauServerController;
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

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', [AuthController::class, 'login']);
    // Route::post('/register', [AuthController::class, 'register']);
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});

Route::get('/tableau/token', [TableauServerController::class, 'getJwtTokenV2']);

Route::get('/menus/listing', [App\Http\Controllers\MenuController::class, 'listing']);
Route::group([
    'prefix' => 'admin',
    'middleware' => ['auth:api', 'admin']
], function () {
    Route::controller(App\Http\Controllers\MenuController::class)
        ->prefix('menus')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{menu}', 'show');
            Route::put('/{menu}', 'update');
            Route::delete('/{menu}', 'destroy');
        });

    Route::controller(App\Http\Controllers\SubMenuController::class)
        ->prefix('sub-menus')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{sub_menu}', 'show');
            Route::put('/{sub_menu}', 'update');
            Route::delete('/{sub_menu}', 'destroy');
        });

    Route::controller(App\Http\Controllers\GroupController::class)
        ->prefix('groups')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{group}', 'show');
            Route::put('/{group}', 'update');
            Route::delete('/{group}', 'destroy');
            Route::get('/{group}/users', 'users');
            Route::post('/{group}/users', 'addUser');
            Route::delete('/{group}/users/{user}', 'removeUser');
        });


    Route::controller(App\Http\Controllers\UserController::class)
        ->prefix('users')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::get('/{user}', 'show');
            Route::put('/{user}', 'update');
            Route::post('/{user}/change-password', 'changePassword');
            Route::post('/{user}/change-status', 'changeStatus');
            Route::get('/{user}/groups', 'groups');
            Route::post('/{user}/groups', 'addGroup');
            Route::delete('/{user}/groups/{group}', 'removeGroup');
        });

    Route::controller(App\Http\Controllers\ReportController::class)
        ->prefix('reports')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
            Route::post('/file', 'uploadFile');
            Route::get('/{report}', 'show');
            Route::put('/{report}', 'update');
            Route::delete('/{report}', 'destroy');
        });

    Route::controller(App\Http\Controllers\MenuPermissionController::class)
        ->prefix('menu-permissions')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
        });

    Route::controller(App\Http\Controllers\TableauServerConfigController::class)
        ->prefix('server-config')
        ->group(function () {
            Route::get('/', 'index');
            Route::post('/', 'store');
        });
});



