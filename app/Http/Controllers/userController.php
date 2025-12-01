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

return redirect('/home');
}

}