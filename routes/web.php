<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InvoiceController;

// PUBLIC ROUTES (Guest Only - khusus tanpa login)

Route::middleware('guest')->group(function () {
//kevin checa satrio 5026221083
    // Login
    Route::get('/', function () {
        return view('Main.welcome');
    })->name('login');

    Route::post('/login', [UserController::class, 'login'])->name('login.store');

    // Registration Step 1: Account
    Route::get('/register', function () {
        return view('Main.register');
    })->name('register');
    Route::post('/register', [UserController::class, 'newUser'])->name('newUser');

    // Registration Step 2: Profile
    Route::get('/new-profile', function () {
        return view('Main.create_profile');
    })->name('profile.create');
    Route::post('/new-profile', [UserController::class, 'saveProfile'])->name('saveProfile');

    // Registration Step 3: Payment Method
    Route::get('/new-method', function () {
        return view('Main.create_payment_method');
    })->name('payment.method');
    Route::post('/new-method', [UserController::class, 'newUserPayment'])->name('savePayment');

    // Registration Step 4: Payment Number
    Route::get('/payment-number', function () {
        return view('Main.payment_number');
    })->name('payment.number');
    Route::post('/finalize-registration', [UserController::class, 'finalizeRegistration'])->name('finalizeRegistration');
});

//  PROTECTED ROUTES (Auth Required - Harus Login)
//ibrahim amar alfanani 5026231195
Route::middleware('auth')->group(function () {

    // Onboarding
    Route::get('/onboarding', function () {
        return view('Main.onboarding');
    })->name('onboarding');

    // Home/Dashboard
    Route::get('/home', function () {
        return view('Main.home');
    })->name('home');

    // STORE ROUTES
    // List & Create
    Route::get('/stores', [StoreController::class, 'listStore'])->name('stores.listStore');
    Route::get('/stores/create', [StoreController::class, 'createStoreView'])->name('stores.createStoreView');
    Route::post('/stores', [StoreController::class, 'addStore'])->name('stores.addStore');

    // Show, Edit, Update, Delete
    Route::get('/stores/{store}', [StoreController::class, 'showStore'])->name('stores.showStore');
    Route::get('/stores/{store}/edit', [StoreController::class, 'editStoreView'])->name('stores.editStoreView');
    Route::put('/stores/{store}', [StoreController::class, 'updateStore'])->name('stores.updateStore');
    Route::delete('/stores/{store}', [StoreController::class, 'deleteStore'])->name('stores.deleteStore');

    // ITEM ROUTES (Nested & Standalone)
    // Create Item (Nested under Store)
    Route::get('/stores/{store}/items/create', [ItemController::class, 'createItemView'])->name('items.createItemView');
    Route::post('/stores/{store}/items', [ItemController::class, 'addItem'])->name('items.addItem');

    // Edit, Update, Delete Item (Standalone)
    Route::get('/items/{item}/edit', [ItemController::class, 'editItem'])->name('items.editItem');
    Route::put('/items/{item}', [ItemController::class, 'updateItem'])->name('items.updateItem');
    Route::delete('/items/{item}', [ItemController::class, 'deleteItem'])->name('items.deleteItem');

    // INVOICE ROUTES
    // Nathaniel Lado Hadi Winata - 5026231019
    
    // List all invoices (incoming & outgoing)
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
    
    // Show specific invoice detail
    Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
    
    // Create invoice from cart
    Route::get('/carts/{cart}/create-invoice', [InvoiceController::class, 'createInvoiceView'])->name('invoices.createInvoiceView');
    Route::post('/carts/{cart}/create-invoice', [InvoiceController::class, 'createInvoice'])->name('invoices.createInvoice');
    
    // Pay invoice
    Route::get('/invoices/{invoice}/pay', [InvoiceController::class, 'payInvoiceView'])->name('invoices.payInvoiceView');
    Route::post('/invoices/{invoice}/pay', [InvoiceController::class, 'processPayment'])->name('invoices.processPayment');
    
    // Payment confirmation
    Route::get('/invoices/{invoice}/confirmation', [InvoiceController::class, 'paymentConfirmation'])->name('invoices.paymentConfirmation');
    
    // Cancel invoice
    Route::delete('/invoices/{invoice}', [InvoiceController::class, 'cancelInvoice'])->name('invoices.cancel');

    // Felix Prajna Santoso - 5026231027
    Route::get('/store/browse', function () {
        return view('managemystore.browsestoreview.storelistview');
    });
    Route::get('/store/browse', function () {
        return view('managemystore.browsestoreview.selectitemtorestockview');
    });
    Route::get('/store/browse', function () {
        return view('managemystore.browsestoreview.landingpageview');
    });
    Route::get('/store/browse', function () {
        return view('managemystore.browsestoreview.addproofofrestockview');
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

    //Komang Alit Pujangga - 5026231115
    Route::get('/profile', [UserController::class, 'manageprofile'])->name('profile');

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
});