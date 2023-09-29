<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
    return redirect()->route('login');
})->name('welcome');

// Route::get('/register', [RegisterController::class, 'create'])->name('register')->middleware('guest');
// Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::get('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordView'])->name('password.request')->middleware('guest');
Route::post('/forgot-password', [ForgotPasswordController::class, 'forgotPasswordSendEmail'])->name('password.email')->middleware('guest');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'resetPasswordView'])->name('password.reset')->middleware('guest');
Route::post('/reset-password', [ResetPasswordController::class, 'resetPasswordNew'])->name('password.update')->middleware('guest');
// if don't have a token, redirect to password.request
Route::get('/reset-password', function () {
    return redirect()->route('password.request');
})->name('password.reset.redirect');

Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

// page dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
// page invoice
Route::resource('/invoice', InvoiceController::class)->middleware('auth');
// page create invoice
Route::post('/invoice/save-items', [InvoiceController::class, 'saveItems'])->name('invoice.saveItem')->middleware('auth');
Route::get('/invoice/edit-items/{itemId}', [InvoiceController::class, 'editItems'])->name('invoice.editItem')->middleware('auth');
Route::put('/invoice/update-items/{itemId}', [InvoiceController::class, 'updateItems'])->name('invoice.updateItem')->middleware('auth');
// page edit invoice
Route::get('/invoice/edit-items-edit/{itemId}', [InvoiceController::class, 'editItemsedit'])->name('invoice.editItemedit')->middleware('auth');
Route::put('/invoice/update-items-update/{itemId}', [InvoiceController::class, 'updateItemsupdate'])->name('invoice.updateItemupdate')->middleware('auth');
// page user
Route::resource('/user', UserController::class)->middleware('auth');
Route::get('/user/edit-user/{userId}', [UserController::class, 'editUser'])->name('user.editUser')->middleware('auth');
Route::put('/user/update-user/{userId}', [UserController::class, 'updateUser'])->name('user.updateUser')->middleware('auth');
Route::post('/user/update-change-password', [UserController::class, 'updatechangePassword'])->name('user.updatechangePassword')->middleware('auth');
// page customer
Route::resource('/customer', CustomerController::class)->middleware('auth');
Route::get('/customer/edit-customer/{customerId}', [CustomerController::class, 'editCustomer'])->name('customer.editCustomer')->middleware('auth');
Route::put('/customer/update-customer/{customerId}', [CustomerController::class, 'updateCustomer'])->name('customer.updateCustomer')->middleware('auth');
// page master Data
// page product
Route::resource('/product', ProductController::class)->middleware('auth');
Route::get('/product/edit-product/{productId}', [ProductController::class, 'editProduct'])->name('product.editProduct')->middleware('auth');
Route::put('/product/update-product/{productId}', [ProductController::class, 'updateProduct'])->name('product.updateProduct')->middleware('auth');
// page type
Route::resource('/type', TypeController::class)->middleware('auth');
Route::get('/type/edit-type/{typeId}', [TypeController::class, 'editType'])->name('type.editType')->middleware('auth');
Route::put('/type/update-type/{typeId}', [TypeController::class, 'updateType'])->name('type.updateType')->middleware('auth');
