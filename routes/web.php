<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;
// PENTING: Import Controller Baru
use App\Http\Controllers\BrowseStoreController;
use App\Http\Controllers\RestockSubmissionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- PUBLIC ROUTES (Guest) ---
Route::middleware('guest')->group(function () {
    Route::get('/', function () { return view('Main.welcome'); })->name('login');
    Route::post('/login', [UserController::class, 'login'])->name('login.store');
    Route::get('/register', function () { return view('Main.register'); })->name('register');
    Route::post('/register', [UserController::class, 'newUser'])->name('newUser');
    Route::get('/new-profile', function () { return view('Main.create_profile'); })->name('profile.create');
    Route::post('/new-profile', [UserController::class, 'saveProfile'])->name('saveProfile');
    Route::get('/new-method', function () { return view('Main.create_payment_method'); })->name('payment.method');
    Route::post('/new-method', [UserController::class, 'newUserPayment'])->name('savePayment');
    Route::get('/payment-number', function () { return view('Main.payment_number'); })->name('payment.number');
    Route::post('/finalize-registration', [UserController::class, 'finalizeRegistration'])->name('finalizeRegistration');
});

// --- PROTECTED ROUTES (Auth Required) ---
Route::middleware('auth')->group(function () {

    Route::get('/onboarding', function () { return view('Main.onboarding'); })->name('onboarding');
    Route::get('/home', function () { return view('Main.home'); })->name('home');
    
    // List Toko
    Route::get('/stores/browse', [BrowseStoreController::class, 'index'])
        ->name('browse.index');

    // Detail Toko (Route ini yang dipanggil di View)
    Route::get('/stores/detail/{idStore}', [BrowseStoreController::class, 'show'])
        ->name('browse.detail');

    // Form & Submit Restock
    Route::get('/restock/item/{idItem}', [RestockSubmissionController::class, 'create'])
        ->name('restock.create');
    Route::post('/restock/submit', [RestockSubmissionController::class, 'store'])
        ->name('restock.store');


    Route::get('/stores', [StoreController::class, 'listStore'])->name('stores.listStore');
    Route::get('/stores/create', [StoreController::class, 'createStoreView'])->name('stores.createStoreView');
    Route::post('/stores', [StoreController::class, 'addStore'])->name('stores.addStore');

    // Route Wildcard (Penyebab error jika ditaruh di atas)
    Route::get('/stores/{store}', [StoreController::class, 'showStore'])->name('stores.showStore');
    Route::get('/stores/{store}/edit', [StoreController::class, 'editStoreView'])->name('stores.editStoreView');
    Route::put('/stores/{store}', [StoreController::class, 'updateStore'])->name('stores.updateStore');
    Route::delete('/stores/{store}', [StoreController::class, 'deleteStore'])->name('stores.deleteStore');


    // Item Routes
    Route::get('/stores/{store}/items/create', [ItemController::class, 'createItemView'])->name('items.createItemView');
    Route::post('/stores/{store}/items', [ItemController::class, 'addItem'])->name('items.addItem');
    Route::get('/items/{item}/edit', [ItemController::class, 'editItem'])->name('items.editItem');
    Route::put('/items/{item}', [ItemController::class, 'updateItem'])->name('items.updateItem');
    Route::delete('/items/{item}', [ItemController::class, 'deleteItem'])->name('items.deleteItem');

    // Invoice Routes
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    Route::get('/carts/{cart}/create-invoice', [InvoiceController::class, 'createInvoiceView'])->name('invoices.createInvoiceView');
    Route::post('/carts/{cart}/create-invoice', [InvoiceController::class, 'createInvoice'])->name('invoices.createInvoice');
    Route::get('/invoices/{invoice}/created', [InvoiceController::class, 'invoiceCreatedConfirmation'])->name('invoices.createdConfirmation');
    Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'processPayment'])->name('invoices.processPayment');
    Route::get('/invoices/{invoice}/confirmation', [InvoiceController::class, 'paymentConfirmation'])->name('invoices.paymentConfirmation');
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'cancelInvoice'])->name('invoices.cancel');

    // Duplicate/alternate routes removed — browse/restock routes consolidated above



    //Komang Alit Pujangga - 5026231115
    Route::get('/profile', [UserController::class, 'manageprofile'])->name('profile');
    Route::get('/profile/edit', [UserController::class, 'editProfile'])->name('editProfile');
    Route::post('/profile/update', [UserController::class, 'updateProfile'])->name('updateProfile');
    Route::get('/profile/changepassword', [UserController::class, 'changePasswordView'])->name('changePasswordView');
    Route::post('/profile/updatepassword', [UserController::class, 'updatePassword'])->name('updatePassword');
    Route::get('/profile/paymentmethods', [UserController::class, 'paymentMethodsView'])->name('paymentMethodsView');
    Route::post('/profile/paymentmethods/default', [UserController::class, 'setDefaultPaymentMethod'])->name('setDefaultPaymentMethod');
    Route::get('/profile/paymentmethods/new', [UserController::class, 'addNewPaymentView'])->name('addPaymentMethodView');
    Route::post('/profile/paymentmethods/store', [UserController::class, 'storePaymentMethod'])->name('storePaymentMethod');
    
    // Logout
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');
});