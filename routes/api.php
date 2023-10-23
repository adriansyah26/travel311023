<?php

use App\Http\Controllers\Api\CustomerApiController;
use App\Http\Controllers\Api\DashboardApiController;
use App\Http\Controllers\Api\ForgotPasswordApiController;
use App\Http\Controllers\Api\InvoiceApiController;
use App\Http\Controllers\Api\LoginApiController;
use App\Http\Controllers\Api\ProductApiController;
use App\Http\Controllers\Api\ResetPasswordApiController;
use App\Http\Controllers\Api\TypeApiController;
use App\Http\Controllers\Api\UserApiController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// api login dan logout
Route::post('/login', [LoginApiController::class, 'login']);
Route::middleware(['auth:api'])->group(function () {
    Route::post('/logout', [LoginApiController::class, 'logout']);
    Route::post('/refresh', [LoginApiController::class, 'refresh']);
    Route::post('/me', [LoginApiController::class, 'me']);
});

// api forgot password
Route::post('/forgot-password', [ForgotPasswordApiController::class, 'forgotPasswordSendEmail']);
Route::post('/reset-password', [ResetPasswordApiController::class, 'resetPasswordNew']);

// api dashboard
Route::middleware(['auth:api'])->group(function () {
    Route::get('/dashboard/index', [DashboardApiController::class, 'index']);
});

// api invoice
Route::middleware(['auth:api'])->group(function () {
    Route::get('/invoice/index', [InvoiceApiController::class, 'index']);
    Route::post('/invoice/store', [InvoiceApiController::class, 'store']);
    Route::get('/invoice/show/{invoiceId}', [InvoiceApiController::class, 'show']);
    Route::put('/invoice/update/{invoiceId}', [InvoiceApiController::class, 'update']);
    Route::post('/invoice/save-items', [InvoiceApiController::class, 'saveItems']);
    Route::get('/invoice/show-items/{itemId}', [InvoiceApiController::class, 'showItems']);
    Route::put('/invoice/update-items/{itemId}', [InvoiceApiController::class, 'updateItems']);
});

// api user
Route::middleware(['auth:api'])->group(function () {
    Route::get('/user/index', [UserApiController::class, 'index']);
    Route::post('/user/store', [UserApiController::class, 'store']);
    Route::get('/user/show/{id}', [UserApiController::class, 'show']);
    Route::put('/user/update/{id}', [UserApiController::class, 'update']);
    Route::post('/user/destroy/{id}', [UserApiController::class, 'destroy']);
    Route::post('/user/update-change-password/{id}', [UserApiController::class, 'updatechangePassword']);
});

// api customer
Route::middleware(['auth:api'])->group(function () {
    Route::get('/customer/index', [CustomerApiController::class, 'index']);
    Route::post('/customer/store', [CustomerApiController::class, 'store']);
    Route::get('/customer/show/{id}', [CustomerApiController::class, 'show']);
    Route::put('/customer/update/{id}', [CustomerApiController::class, 'update']);
});

// api product
Route::middleware(['auth:api'])->group(function () {
    Route::get('/product/index', [ProductApiController::class, 'index']);
    Route::post('/product/store', [ProductApiController::class, 'store']);
    Route::get('/product/show/{id}', [ProductApiController::class, 'show']);
    Route::put('/product/update/{id}', [ProductApiController::class, 'update']);
});

// api type
Route::middleware(['auth:api'])->group(function () {
    Route::get('/type/index', [TypeApiController::class, 'index']);
    Route::post('/type/store', [TypeApiController::class, 'store']);
    Route::get('/type/show/{id}', [TypeApiController::class, 'show']);
    Route::put('/type/update/{id}', [TypeApiController::class, 'update']);
});
