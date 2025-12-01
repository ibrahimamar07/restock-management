<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;

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

Route::get('/', function () {
    return view('managemystore.mystoreview');
});
Route::get('/store/add', function () {
    return view('managemystore.additemstoreview');
});

Route::get('/store/setup', function () {
    return view('managemystore.setupstoreview');
});
Route::get('/store/edit', function () {
    return view('managemystore.editstoreview');
});
Route::get('/store/detail', function () {
    return view('managemystore.storedetailview');
});
Route::get('/store/browse', function () {
    return view('managemystore.browsestoreview.storelistview');
});


//route profile
Route::get('/profile', [userController::class, 'manageprofile']);
Route::get('/profile/edit', [userController::class, 'editprofile']);
Route::get('/profile/changepassword', [userController::class, 'changepassword']);
Route::get('/profile/paymentmethods', [userController::class, 'paymentmethods']);
