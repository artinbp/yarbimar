<?php

use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CarouselController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\Dashboard\CarouselController as DashboardCarouselController;
use App\Http\Controllers\Api\Dashboard\CategoryController as DashboardCategoryController;
use App\Http\Controllers\Api\Dashboard\DiseaseController as DashboardDiseaseController;
use App\Http\Controllers\Api\Dashboard\MediaController as DashboardMediaController;
use App\Http\Controllers\Api\Dashboard\OrderController as DashboardOrderController;
use App\Http\Controllers\Api\Dashboard\ProductController as DashboardProductController;
use App\Http\Controllers\Api\Dashboard\RoleController as DashboardRoleController;
use App\Http\Controllers\Api\Dashboard\ShippingMethodController as DashboardShippingMethodController;
use App\Http\Controllers\Api\Dashboard\UserAddressController as DashboardUserAddressController;
use App\Http\Controllers\Api\Dashboard\UserController as DashboardUserController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\ShippingMethodController;
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

// ---------- Auth Routes ----------

Route::get('/v1/auth/user', [AuthController::class, 'user'])->middleware('auth:sanctum');
Route::post('/v1/auth/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/v1/auth/login', [AuthController::class, 'login'])->middleware('guest');
Route::post('/v1/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// ---------- Dashboard Routes ----------

Route::get('/v1/dashboard/roles', [DashboardRoleController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/users', [DashboardUserController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/users', [DashboardUserController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/users/{id}', [DashboardUserController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/users/{id}', [DashboardUserController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/users/{id}', [DashboardUserController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/users/{user}/addresses', [DashboardUserAddressController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/users/{user}/addresses', [DashboardUserAddressController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/users/{user}/addresses/{address}', [DashboardUserAddressController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/users/{user}/addresses/{address}', [DashboardUserAddressController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/users/{user}/addresses/{address}', [DashboardUserAddressController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/shipping_methods', [DashboardShippingMethodController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/shipping_methods', [DashboardShippingMethodController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/shipping_methods/{id}', [DashboardShippingMethodController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/shipping_methods/{id}', [DashboardShippingMethodController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/shipping_methods/{id}', [DashboardShippingMethodController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/diseases', [DashboardDiseaseController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/diseases', [DashboardDiseaseController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/diseases/{id}', [DashboardDiseaseController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/diseases/{id}', [DashboardDiseaseController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/diseases/{id}', [DashboardDiseaseController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/media', [DashboardMediaController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/media', [DashboardMediaController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/media/{id}', [DashboardMediaController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/categories', [DashboardCategoryController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/categories', [DashboardCategoryController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/categories/{id}', [DashboardCategoryController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/categories/{id}', [DashboardCategoryController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/categories/{id}', [DashboardCategoryController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/products', [DashboardProductController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/products', [DashboardProductController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/products/{id}', [DashboardProductController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/products/{id}', [DashboardProductController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/products/{id}', [DashboardProductController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/orders', [DashboardOrderController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/orders/{id}', [DashboardOrderController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/orders/{id}', [DashboardOrderController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/orders/{id}', [DashboardOrderController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/dashboard/carousel', [DashboardCarouselController::class, 'list'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::post('/v1/dashboard/carousel', [DashboardCarouselController::class, 'create'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/dashboard/carousel/{id}', [DashboardCarouselController::class, 'read'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::patch('/v1/dashboard/carousel/{id}', [DashboardCarouselController::class, 'update'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::delete('/v1/dashboard/carousel/{id}', [DashboardCarouselController::class, 'delete'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);

Route::get('/v1/profile/addresses', [AddressController::class, 'list'])->middleware('auth:sanctum');
Route::post('/v1/profile/addresses', [AddressController::class, 'create'])->middleware('auth:sanctum');
Route::get('/v1/profile/addresses/{id}', [AddressController::class, 'read'])->middleware('auth:sanctum');
Route::patch('/v1/profile/addresses/{id}', [AddressController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/v1/profile/addresses/{id}', [AddressController::class, 'delete'])->middleware('auth:sanctum');

Route::get('/v1/profile/orders', [OrderController::class, 'list'])->middleware('auth:sanctum');
Route::post('/v1/profile/orders', [OrderController::class, 'create'])->middleware('auth:sanctum');
Route::get('/v1/profile/orders/{id}', [OrderController::class, 'read'])->middleware('auth:sanctum');
Route::get('/v1/profile/orders/{id}/cancel', [OrderController::class, 'cancel'])->middleware('auth:sanctum');
Route::post('/v1/orders/{id}/pay', [OrderController::class, 'pay'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin']);
Route::get('/v1/orders/transactions/{transactionId}/verify', [OrderController::class, 'verify'])->middleware(['auth:sanctum', 'role:role_admin,role_super_admin'])
    ->name('order.transaction.verify');

Route::get('/v1/shipping_methods', [ShippingMethodController::class, 'list'])->middleware('auth:sanctum');
Route::post('/v1/orders/cost', [OrderController::class, 'cost'])->middleware('auth:sanctum');

Route::get('/v1/cart', [CartController::class, 'list'])->middleware('auth:sanctum');
Route::post('v1/cart/add', [CartController::class, 'add'])->middleware('auth:sanctum');
Route::post('/v1/cart/remove', [CartController::class, 'remove'])->middleware('auth:sanctum');

// ---------- Public Routes ----------

Route::get('/v1/categories', [CategoryController::class, 'list']);
Route::get('/v1/products', [ProductController::class, 'list']);
Route::get('/v1/carousel', [CarouselController::class, 'list']);
