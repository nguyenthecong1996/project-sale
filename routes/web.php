<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomAuthController;
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
Route::get('login', [CustomAuthController::class, 'index'])->name('login');
Route::post('login', [CustomAuthController::class, 'customLogin'])->name('login.custom'); 
Route::get('registration', [CustomAuthController::class, 'registration'])->name('register-user');
Route::post('registration', [CustomAuthController::class, 'customRegistration'])->name('register.custom');
Route::get('signout', [CustomAuthController::class, 'signOut'])->name('signout'); 

Route::group(['middleware' => 'checkUser'], function () {
    Route::post('users', [UserController::class, 'store'])->name('users.store');

    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::post('customers/store', [CustomerController::class, 'store'])->name('customers.store');
    Route::delete('customers/{id}/delete', [CustomerController::class, 'destroy'])->name('customers.delete');
    
    Route::get('products', [ProductController::class, 'index'])->name('products.index');
    Route::get('products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
    Route::post('products/store', [ProductController::class, 'store'])->name('products.store');
    Route::delete('products/{id}/delete', [ProductController::class, 'destroy'])->name('products.delete');
});
