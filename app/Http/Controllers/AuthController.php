<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm(){
        return view('lgoin');
    }

    
    public function login(Request $request){
        $credentials = $request->only('username','password');

        if(Auth::attempt($credentials)){
            return redirect()->intended(default: 'dashboard');
        }else{
            return back()->withErrors([
                'email' => 'Invalid email or password.'
            ]);
        }
    }

    public function getUserCredentials(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        
    }
}
