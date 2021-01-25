<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\CriteriaController;
use App\Http\Controllers\CustomerValueController;
use App\Http\Controllers\CalculationController;

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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::resource('customers', CustomerController::class);
Route::resource('criteria', CriteriaController::class);
Route::resource('customer-value', CustomerValueController::class);
Route::resource('calculation', CalculationController::class);

// reports
Route::get('/report', [App\Http\Controllers\CalculationController::class, 'reports'])->name('reports');
Route::get('/report-all', [App\Http\Controllers\CalculationController::class, 'printAllCustomerReport'])->name('report-all');
Route::get('/report-rank', [App\Http\Controllers\CalculationController::class, 'printRankCustomerReport'])->name('report-rank');
