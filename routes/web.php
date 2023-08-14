<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PenggunaController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TypeController;
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

Route::view('/home', 'home')->name('home');
Route::get('/register', [RegisterController::class, 'create'])->name('register')->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/login', [LoginController::class, 'login'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', function () {
    auth()->logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/');
})->name('logout')->middleware('auth');
Route::view('/home', 'home')->name('home')->middleware('auth');

Route::get('/home', [HomeController::class, 'index'])->middleware('auth');
Route::resource('/dashboard', DashboardController::class)->middleware('auth');
Route::resource('/invoice', InvoiceController::class)->middleware('auth');
Route::post('/invoice/save-items', [InvoiceController::class, 'saveItems'])->name('invoice.saveItem')->middleware('auth');
Route::get('/invoice/edit-items/{itemId}', [InvoiceController::class, 'editItems'])->name('invoice.editItem')->middleware('auth');
Route::put('/invoice/update-items/{itemId}', [InvoiceController::class, 'updateItems'])->name('invoice.updateItem')->middleware('auth');
Route::resource('/pengguna', PenggunaController::class)->middleware('auth');
Route::resource('/customer', CustomerController::class)->middleware('auth');
// Master Data
Route::resource('/product', ProductController::class)->middleware('auth');
Route::resource('/type', TypeController::class)->middleware('auth');
