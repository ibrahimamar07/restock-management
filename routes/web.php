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
Route::get('/profile', [UserController::class, 'manageprofile']);

// Rute GET untuk menampilkan form edit (memanggil UserController)
Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('editProfile');

// TAMBAH: Rute POST untuk menyimpan perubahan (termasuk upload foto)
Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('updateProfile');

// Rute GET untuk menampilkan form change password (memanggil UserController)
Route::get('/profile/changepassword', [UserController::class, 'changePasswordView'])->name('changePasswordView');

// TAMBAH: Rute POST untuk memproses perubahan password
Route::post('/profile/updatepassword', [UserController::class, 'updatePassword'])->name('updatePassword');

// Rute untuk menampilkan daftar payment methods (sudah ada)
Route::get('/profile/paymentmethods', [UserController::class, 'paymentMethodsView'])->name('paymentMethodsView');

// TAMBAHKAN: Rute POST untuk mengatur metode pembayaran default
Route::post('/profile/paymentmethods/default', [UserController::class, 'setDefaultPaymentMethod'])->name('setDefaultPaymentMethod');

// TAMBAH: Rute GET untuk menampilkan form tambah payment method baru (menggunakan view baru)
Route::get('/profile/paymentmethods/new', [UserController::class, 'addNewPaymentView'])->name('addPaymentMethodView');

// TAMBAH: Rute POST untuk menyimpan payment method baru (untuk user yang sudah login)
Route::post('/profile/paymentmethods/store', [UserController::class, 'storePaymentMethod'])->name('storePaymentMethod');

