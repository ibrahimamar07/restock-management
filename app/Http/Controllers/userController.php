<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Create a new user from form input.
     * Expects POST with 'email', 'username', 'password'.
     */
    public function newUser(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:users,email',
            'username' => 'required|string|max:255|unique:users,username',
            'password' => 'required|string|min:6',
        ]);

        DB::table('users')->insert([
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect('/')->with('success', 'Account created.');
    }

    /**
     * Login using username and password.
     * Expects POST with 'username' and 'password'.
     * On success stores user id in session and redirects, on failure returns error.
     */
    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $user = DB::table('users')->where('username', $data['username'])->first();

        if (! $user || ! Hash::check($data['password'], $user->password)) {
            return back()->with('error', 'username and password incorrect');
        }

        // basic session login (adjust to your auth system as needed)
        $request->session()->put('user_id', $user->id);

        return redirect('/')->with('success', 'Logged in.');
    }
}

