<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\storeController;
use App\Http\Controllers\itemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::get('/stores', [storeController::class, 'index'])->name('stores.index');
Route::get('/stores/create', [storeController::class, 'create'])->name('stores.create');
Route::post('/stores', [storeController::class, 'store'])->name('stores.store');


Route::get('/stores/{store}', [storeController::class, 'show'])->name('stores.show');
Route::get('/stores/{store}/edit', [storeController::class, 'edit'])->name('stores.edit');
Route::put('/stores/{store}', [storeController::class, 'update'])->name('stores.update');
Route::delete('/stores/{store}', [storeController::class, 'destroy'])->name('stores.destroy');


Route::get('/stores/{store}/items/create', [ItemController::class, 'create'])->name('items.create');
Route::post('/stores/{store}/items', [ItemController::class, 'store'])->name('items.store');


Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');