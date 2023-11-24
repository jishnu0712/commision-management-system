<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // LOGIN FORM
    public function index() {
        return view('login');
    }

    // LOGIN
    public function login(Request $request){
        $request->validate([
            "username" => ['required'],
            "password" => ['required']
        ],[
            "username.required" => 'Please enter Username!',
            "password.required" => 'Please enter Password!',
        ]);

        $rememberme = false;
        if($request->has('rememberme')){
            $rememberme = true;
        }

        if(Auth::attempt(['username' => $request->username, 'password' => $request->password], $rememberme)){
            $request->session()->regenerate();
            return redirect()->route('dashboard.index');
            echo 'Loggedin successful';
        }else{
            return back()->with('error', 'Wrong Username or Password!');
        }
        
    }
}
