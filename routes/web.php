<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceProductController;
use App\Http\Controllers\SummaryController;

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
    return view('welcome');
});

Route::resource('/product', ProductController::class, [
    'only' => ['index', 'store', 'update', 'destroy']
]);

Route::resource('/invoice', InvoiceController::class, [
    'only' => ['index', 'store', 'update', 'destroy']
]);

Route::post('/invoice/{invoice}/email', [InvoiceController::class, 'email']);
Route::post('invoice/{invoice}/archive', [InvoiceController::class,'archive']);

Route::put('/invoice/{invoice}/products/{invoiceProduct}', [InvoiceProductController::class,'update']);
Route::delete('/invoice/{invoice}/products/{invoiceProduct}', [InvoiceProductController::class,'destroy']);
Route::post('/invoice/{invoice}/products', [InvoiceProductController::class,'store']);

Route::get('/summary', [SummaryController::class,'index']);
Route::get('/summary/{summary}', [SummaryController::class,'view']);