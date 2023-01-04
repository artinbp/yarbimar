<?php

use App\Http\Controllers\Api\V1\AuthApiController as V1AuthApiController;
use App\Http\Controllers\Api\V1\AddressApiController as V1AddressApiController;
use App\Http\Controllers\Api\V1\CategoryApiController as V1CategoryApiController;
use App\Http\Controllers\Api\V1\ProductApiController as V1ProductApiController;
use App\Http\Controllers\Api\V1\OrderApiController as V1OrderApiController;

use App\Http\Controllers\Api\V1\Admin\CategoryApiController as V1AdminCategoryApiController;
use App\Http\Controllers\Api\V1\Admin\ProductApiController as V1AdminProductApiController;
use App\Http\Controllers\Api\V1\Admin\RoleApiController as V1AdminRoleApiController;
use App\Http\Controllers\Api\V1\Admin\UserApiController as V1AdminUserApiController;
use App\Http\Controllers\Api\V1\Admin\MediaApiController as V1AdminMediaApiController;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/v1/user', function (Request $request) {
    return $request->user()['id'];
});

Route::post('/v1/auth/register', [V1AuthApiController::class, 'register']);
Route::post('/v1/auth/login', [V1AuthApiController::class, 'login']);
Route::post('/v1/auth/logout', [V1AuthApiController::class, 'logout'])->middleware('auth:sanctum');

Route::get('/v1/addresses', [V1AddressApiController::class, 'list']);
Route::post('/v1/addresses', [V1AddressApiController::class, 'create']);
Route::get('/v1/addresses/{id}', [V1AddressApiController::class, 'read']);
Route::patch('/v1/addresses/{id}', [V1AddressApiController::class, 'update']);
Route::delete('/v1/addresses/{id}', [V1AddressApiController::class, 'delete']);

Route::get('/v1/admin/categories', [V1AdminCategoryApiController::class, 'list']);
Route::post('/v1/admin/categories', [V1AdminCategoryApiController::class, 'create']);
Route::get('/v1/admin/categories/{id}', [V1AdminCategoryApiController::class, 'read']);
Route::patch('/v1/admin/categories/{id}', [V1AdminCategoryApiController::class, 'update']);
Route::delete('/v1/admin/categories/{id}', [V1AdminCategoryApiController::class, 'delete']);

Route::get('/v1/admin/products', [V1AdminProductApiController::class, 'list']);
Route::post('/v1/admin/products', [V1AdminProductApiController::class, 'create']);
Route::get('/v1/admin/products/{id}', [V1AdminProductApiController::class, 'read']);
Route::patch('/v1/admin/products/{id}', [V1AdminProductApiController::class, 'update']);
Route::delete('/v1/admin/products/{id}', [V1AdminProductApiController::class, 'delete']);

Route::get('/v1/admin/roles', [V1AdminRoleApiController::class, 'list']);

Route::get('/v1/admin/users', [V1AdminUserApiController::class, 'list']);
Route::post('/v1/admin/users', [V1AdminUserApiController::class, 'create']);
Route::get('/v1/admin/users/{id}', [V1AdminUserApiController::class, 'read']);
Route::patch('/v1/admin/users/{id}', [V1AdminUserApiController::class, 'update']);
Route::delete('/v1/admin/users/{id}', [V1AdminUserApiController::class, 'delete']);

Route::get('/v1/admin/media', [V1AdminMediaApiController::class, 'list']);
Route::post('/v1/admin/media', [V1AdminMediaApiController::class, 'create']);
Route::delete('/v1/admin/media/{id}', [V1AdminMediaApiController::class, 'delete']);


Route::get('/v1/orders', [V1OrderApiController::class, 'list']);
Route::post('/v1/orders', [V1OrderApiController::class, 'create']);
Route::post('/v1/orders/{id}', [V1OrderApiController::class, 'read']);
Route::get('/v1/orders/{id}/cancel', [V1OrderApiController::class, 'cancel']);
Route::get('/v1/orders/{id}/purchase', [V1OrderApiController::class], 'purchase');

Route::get('/v1/categories', [V1CategoryApiController::class, 'list']);
Route::get('/v1/products', [V1ProductApiController::class, 'list']);
