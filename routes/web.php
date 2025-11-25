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

// Route::get('/', function () {
//     return view('managemystore.mystoreview');
// });
// Route::get('/store/add', function () {
//     return view('managemystore.additemstoreview');
// });

// Route::get('/store/setup', function () {
//     return view('managemystore.setupstoreview');
// });
// Route::get('/store/edit', function () {
//     return view('managemystore.editstoreview');
// });
// Route::get('/store/detail', function () {
//     return view('managemystore.storedetailview');
// });
// Route::get('/store/browse', function () {
//     return view('managemystore.browsestoreview.storelistview');
// });


Route::get('/stores', [storeController::class, 'index'])->name('stores.index');
    Route::get('/stores/create', [storeController::class, 'create'])->name('stores.create');
    Route::post('/stores', [storeController::class, 'store'])->name('stores.store');
    Route::get('/stores/{id}', [storeController::class, 'show'])->name('stores.show');
    Route::get('/stores/{id}/edit', [storeController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{id}', [storeController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{id}', [storeController::class, 'destroy'])->name('stores.destroy');

    // Item CRUD
    Route::get('/stores/{storeId}/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/stores/{storeId}/items', [ItemController::class, 'store'])->name('items.store');
    Route::get('/items/{id}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{id}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('items.destroy');