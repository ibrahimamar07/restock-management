<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\UserController;


// PUBLIC ROUTES (Guest Only - khusus tanpa login)

//kevin checa satrio 5026221083
Route::middleware('guest')->group(function () {

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


    // List & Create
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');

    // Show, Edit, Update, Delete
    Route::get('/stores/{store}', [StoreController::class, 'show'])->name('stores.show');
    Route::get('/stores/{store}/edit', [StoreController::class, 'edit'])->name('stores.edit');
    Route::put('/stores/{store}', [StoreController::class, 'update'])->name('stores.update');
    Route::delete('/stores/{store}', [StoreController::class, 'destroy'])->name('stores.destroy');

    // ITEM ROUTES (Nested & Standalone)

    // Create Item (Nested under Store)
    Route::get('/stores/{store}/items/create', [ItemController::class, 'create'])->name('items.create');
    Route::post('/stores/{store}/items', [ItemController::class, 'store'])->name('items.store');

    // Edit, Update, Delete Item (Standalone)
    Route::get('/items/{item}/edit', [ItemController::class, 'edit'])->name('items.edit');
    Route::put('/items/{item}', [ItemController::class, 'update'])->name('items.update');
    Route::delete('/items/{item}', [ItemController::class, 'destroy'])->name('items.destroy');




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

    //Nathaniel Lado Hadi Winata - 5026231019
    Route::get('/store/invoice', function () {
        return view('managemystore.invoiceview.createinvoice');
    });
    Route::get('/store/invoice', function () {
        return view('managemystore.invoiceview.payinvoice');
    });
    Route::get('/store/invoice', function () {
        return view('managemystore.invoiceview.viewinvoice');
    });
    Route::get('/store/invoice', function () {
        return view('managemystore.invoiceview.viewinvoicedetail');
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
});
