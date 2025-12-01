<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
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

// Muhammad Kevin Checa Satrio - 5026221083
Route::get('/login', function () {
    return view('Main.welcome');
});

Route::get('/register', function () {
    return view('Main.register');
});

Route::get('/new-profile', function () {
    return view('Main.create_profile');
});

Route::get('/new-method', function () {
    return view('Main.create_payment_method');
});

Route::get('/payment-number', function () {
    return view('Main.payment_number');
});

Route::get('/home', function () {
    return view('Main.home');
});

Route::get('/onboarding', function () {
    return view('Main.onboarding');
});



Route::get('/register', function () {
    return view('Main.register'); // <-- name of your Blade file
})->name('register');

Route::post('/register', [UserController::class, 'newUser'])->name('newUser');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::post('/new-profile', [UserController::class, 'saveProfile'])->name('saveProfile');

Route::post('/new-method', [UserController::class, 'newUserPayment'])->name('savePayment');

Route::post('/finalize-registration', [UserController::class, 'finalizeRegistration'])->name('finalizeRegistration');


//Komang Alit Pujangga - 5026231115
Route::get('/profile', function () {
    return view('manageprofile.profilepageview');
});

Route::get('/profile/edit', function () {
    return view('manageprofile.editprofileview');
});

Route::get('/profile/changepassword', function () {
    return view('manageprofile.changepasswordview');
});

Route::get('/profile/paymentmethods', function () {
    return view('manageprofile.paymentmethodsmenuview');
});

