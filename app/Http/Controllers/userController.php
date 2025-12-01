<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class userController extends Controller
{
    //
    public function manageprofile(){
        // memanggil profilepageview
        return view('manageprofile.profilepageview');
    }

    public function editprofile(){
        // memanggil editprofileview
        return view('manageprofile.editprofileview');
    }

    public function changepassword(){
        // memanggil editprofileview
        return view('manageprofile.changepasswordview');
    }

    public function paymentmethods(){
        // memanggil editprofileview
        return view('manageprofile.paymentmethodsmenuview');
    }
}
