<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserPaymentType;

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



public function login(Request $request)
{
    // Validate input
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    // Find user by username
    $user = User::where('username', $request->username)->first();

    // If username not found
    if (!$user) {
        return redirect()->back()->with('error', 'Username not found.');
    }

    // Check password
    if (!Hash::check($request->password, $user->password)) {
        return redirect()->back()->with('error', 'Incorrect password.');
    }

    // Store session
    Session::put('user_id', $user->idUser);
    Session::put('username', $user->username);

    // Redirect to home/dashboard
    return redirect('/home');
}

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

// Now $user exists outside the closure
Session::put('user_id', $user->idUser);
Session::put('username', $user->username);

// Clear registration session
session()->forget([
    'reg_email', 'reg_username', 'reg_password',
    'reg_nickname', 'reg_description', 'reg_profilepic',
    'reg_payment_type'
]);

return redirect('/home');
}

}