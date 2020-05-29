<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\AppController;

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

Route::get('/list', [InventoryController::class, 'index']);
Route::get('/create', [InventoryController::class, 'create']);
Route::get('/items/export', [InventoryController::class, 'exportInventory']);

Route::post('/item/store', [InventoryController::class, 'store']);
Route::post('/item/{id}/delete', [InventoryController::class, 'destroy']);
Route::post('/item/{item}/add_stocks', [InventoryController::class, 'addStocks']);
Route::post('/item/{item}/update', [InventoryController::class, 'update']);

Route::get('/', [AppController::class, 'index'])->where('/', '.*');
