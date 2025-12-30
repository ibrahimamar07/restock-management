<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserPaymentType;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

// Muhammad Kevin Checa Satrio - 5026221083
public function newUser(Request $request)
{
    // Validate fields
    $request->validate([
        'email' => 'required|email',
        'username' => 'required|min:3',
        'password' => 'required|min:6'
    ]);

    // Check duplicate email
    if (User::where('email', $request->email)->exists()) {
        return redirect()->back()->with('error', 'Email already registered.');
    }

    // Check duplicate username
    if (User::where('username', $request->username)->exists()) {
        return redirect()->back()->with('error', 'Username already taken.');
    }

    // Store data IN SESSION (not database yet)
    session([
        'reg_email'    => $request->email,
        'reg_username' => $request->username,
        'reg_password' => Hash::make($request->password),
    ]);

    // Go to create profile screen
    return redirect('/new-profile');
}


//fungsi login nya tak ubah mas pakai auth bawaan laravel biar buat midleware gampang tinggal panggil auth aja
//start modified fungsi login by ibrahim amar alfanani 5026231195
public function login(Request $request)
    {
        // 1. Validate input
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        // 2. baauat Kredensial
        // Auth::attempt akan mencari user berdasarkan 'username' DAN mencocokkan 'password'
        $credentials = [
            'username' => $request->username,
            'password' => $request->password,
        ];
        
        //  proses autentikasi
        if (Auth::attempt($credentials)) {
            
            // 3. Login Berhasil: Regenerasi Session ID 
            $request->session()->regenerate();
            
            // 4. Redirect ke halaman yang home
            return redirect()->intended('/home');
        } 
        
        // 5. Login Gagal: Username atau Password salah
        
        return redirect()->back()->with('error', 'Username atau Password salah.');
    }
//end modified fungsi login by ibrahim amar alfanani 5026231195

public function saveProfile(Request $request)
{
    // Validate
    $request->validate([
        'nickname' => 'required|min:2',
        'description' => 'nullable',
        'profilepic' => 'nullable|image|max:2048', // 2MB
    ]);

    // Handle image upload if exists
    $tempPath = null;

    if ($request->hasFile('profilepic')) {
        $tempPath = $request->file('profilepic')->store('temp_profile', 'public');
    }

    // Save to session
    session([
        'reg_nickname' => $request->nickname,
        'reg_description' => $request->description,
        'reg_profilepic' => $tempPath,
    ]);

    // Move to next page
    return redirect('/new-method');
}

public function newUserPayment(Request $request)
{
    // Validate payment type (must be 3 for now)
    $request->validate([
        'payment_type' => 'required|in:3',
    ]);

    // Save selected payment method into session
    session([
        'reg_payment_type' => $request->payment_type,
    ]);

    // Move to next page (payment number)
    return redirect('/payment-number');
}

public function finalizeRegistration(Request $request)
{
    // Validate payment number
    $request->validate([
        'payment_number' => 'required|numeric|min:10000000',
    ]);

    // Retrieve session data
    $email = session('reg_email');
    $username = session('reg_username');
    $password = session('reg_password');
    $nickname = session('reg_nickname');
    $description = session('reg_description');
    $profilepic = session('reg_profilepic'); // temp path
    $paymentType = session('reg_payment_type');
    $paymentNumber = $request->payment_number;
    $user = null; // define before the closure

DB::transaction(function () use ($email, $username, $password, $nickname, $description, $profilepic, $paymentType, $paymentNumber, &$user) {

    $finalProfilePath = null;

    if ($profilepic) {
        $folder = 'profile_pics/' . date('Y/m/d');
        $filename = uniqid() . '_' . basename($profilepic);
        $finalProfilePath = $folder . '/' . $filename;

        Storage::disk('public')->move($profilepic, $finalProfilePath);
    }

    $user = User::create([
        'email' => $email,
        'username' => $username,
        'password' => $password,
        'nickname' => $nickname,
        'description' => $description,
        'profilepic' => $finalProfilePath,
    ]);

    UserPaymentType::create([
        'idUser' => $user->idUser,
        'idPaymentType' => $paymentType,
        'paymentDetails' => $paymentNumber,
    ]);
});

//ini juga tak ubah pakai auth laravel
//start modified by ibrahim amar alfanani 5026231195
// Now $user exists outside the closure
Auth::login($user); 
        $request->session()->regenerate();
// Session::put('user_id', $user->idUser);
// Session::put('username', $user->username);

//end modified by ibrahim amar alfanani 5026231195

// Clear registration session
session()->forget([
    'reg_email', 'reg_username', 'reg_password',
    'reg_nickname', 'reg_description', 'reg_profilepic',
    'reg_payment_type'
]);

return redirect('/onboarding');
}


//Komang Alit Pujangga - 5026231115
//profilepage
public function manageprofile()
{
    // Ambil ID pengguna dari Session yang disimpan saat login
    // $userId = Session::get('user_id');

    // // Cari data pengguna berdasarkan ID. Gunakan find() karena idUser adalah Primary Key
    // $user = User::find($userId);

    $user = Auth::user();


    // Cek jika pengguna tidak ditemukan (misal, session kedaluwarsa)
    if (!$user) {
        // Arahkan kembali ke login jika tidak ada data user
        return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
    }

    // Kirim objek $user ke view
    return view('manageprofile.profilepageview', [
        'user' => $user
    ]);
}

//editprofilepage
public function editProfile()
{
    // $userId = Session::get('user_id');
    // $user = User::find($userId);
    $user = Auth::user();

    if (!$user) {
        // Redirect jika sesi tidak valid
        return redirect()->route('login')->with('error', 'Sesi Anda telah berakhir. Silakan login kembali.');
    }

    // Mengirim objek $user ke view editprofileview
    return view('manageprofile.editprofileview', compact('user'));
}

//editprofilepage
public function updateProfile(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'nickname' => 'nullable|string|max:100',
        'description' => 'nullable|string',
        'profilepic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Maks 2MB, hanya format gambar
    ]);

    // 2. Ambil Data User
    // $userId = Session::get('user_id');
    // $user = User::find($userId);
    $user = Auth::user();

    if (!$user) {
        return redirect('/profile')->with('error', 'Gagal memperbarui profil.');
    }

    // 3. Handle File Upload (Profile Picture)
    if ($request->hasFile('profilepic')) {
        // Hapus foto lama jika ada
        if ($user->profilepic && Storage::disk('public')->exists($user->profilepic)) {
            Storage::disk('public')->delete($user->profilepic);
        }

        // Simpan file baru ke folder 'profile_pics' di storage/app/public
        $path = $request->file('profilepic')->store('profile_pics', 'public');
        $user->profilepic = $path;
    }

    // 4. Update data lainnya
    $user->nickname = $request->nickname;
    $user->description = $request->description;

    // 5. Simpan ke database
    $user->save();

    // 6. Redirect kembali ke halaman profil
    return redirect('/profile')->with('success', 'Profil berhasil diperbarui!');
}

//changepassword
public function changePasswordView()
{
    // Cek apakah user sedang login
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Silakan login kembali.');
    }

    // Hanya menampilkan view
    return view('manageprofile.changepasswordview');
}

//changepassword
public function updatePassword(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'oldPassword' => 'required',
        'newPassword' => 'required|min:6',
        'confirmPassword' => 'required|same:newPassword',
    ], [
        'confirmPassword.same' => 'Konfirmasi Password Baru tidak cocok.',
    ]);

    // 2. Ambil Data User yang Sedang Login
    // $userId = Session::get('user_id');
    // $user = User::find($userId);
    $user = Auth::user();

    if (!$user) {
         return redirect()->route('login')->with('error', 'Sesi tidak valid.');
    }

    // 3. Verifikasi Password Lama
    if (!Hash::check($request->oldPassword, $user->password)) {
        // Redirect dengan error jika password lama salah
        return redirect()->back()->with('error', 'Password lama yang Anda masukkan salah.');
    }

    // 4. Update Password Baru
    $user->password = Hash::make($request->newPassword);
    $user->save();

    // 5. Redirect ke halaman profile dengan pesan sukses
    return redirect('/profile')->with('success', 'Password berhasil diperbarui!');
}

//paymentmethodsmenu
public function paymentMethodsView()
{
    if (!Auth::check()) {
         return redirect()->route('login')->with('error', 'Silakan login kembali.');
    }

    // $userId = Session::get('user_id');
    $userId = Auth::id();

    $paymentMethods = DB::table('user_payment_types')
        ->join('payment_types', 'user_payment_types.idPaymentType', '=', 'payment_types.idPaymentType')
        ->where('user_payment_types.idUser', $userId)
        // TAMBAHKAN is_default dalam select
        ->select('payment_types.paymentName', 'user_payment_types.paymentDetails', 'user_payment_types.idUserPaymentType', 'user_payment_types.is_default')
        ->get();

    return view('manageprofile.paymentmethodsmenuview', [
        'paymentMethods' => $paymentMethods
    ]);
}

//paymentmethodsmenu
public function setDefaultPaymentMethod(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'idUserPaymentType' => 'required|exists:user_payment_types,idUserPaymentType',
    ]);

    $userId = Auth::id();
    $selectedId = $request->idUserPaymentType;

    DB::transaction(function () use ($userId, $selectedId) {
        // 2. Set semua metode pembayaran user menjadi BUKAN default
        UserPaymentType::where('idUser', $userId)
                       ->update(['is_default' => 0]);

        // 3. Set metode pembayaran yang dipilih menjadi DEFAULT (1)
        UserPaymentType::where('idUserPaymentType', $selectedId)
                       ->where('idUser', $userId) // pastikan user hanya bisa mengubah miliknya
                       ->update(['is_default' => 1]);
    });

    return redirect()->route('paymentMethodsView')->with('success', 'Metode pembayaran default berhasil diubah!');
}

//newpaymentmethod
public function addNewPaymentView()
{
    if (!Auth::check()) {
         return redirect()->route('login')->with('error', 'Silakan login kembali.');
    }

    // Ambil semua tipe pembayaran dari database (ID 1, 2, 3, 4, dst.)
    $availablePaymentTypes = DB::table('payment_types')
                               ->select('idPaymentType', 'paymentName')
                               ->get();

    // Menggunakan view baru: newpaymentmethod.blade.php
    return view('manageprofile.newpaymentmethod', [
        'availablePaymentTypes' => $availablePaymentTypes // Kirim data
    ]);
}

//storepaymentmethods
public function storePaymentMethod(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->with('error', 'Sesi tidak valid.');
    }

    $request->validate([
        'idPaymentType' => 'required|integer', // Sesuaikan validasi dengan DB
        'paymentDetails' => 'required|string|max:255',
    ]);

    $userId = Auth::id();

    // Simpan ke database
    UserPaymentType::create([
        'idUser' => $userId,
        'idPaymentType' => $request->idPaymentType,
        'paymentDetails' => $request->paymentDetails,
    ]);

    return redirect()->route('paymentMethodsView')->with('success', 'Metode pembayaran berhasil ditambahkan!');
}

}//controller



