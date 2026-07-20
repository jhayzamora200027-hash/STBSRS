<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $Request)
    {
        $credentials = $Request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
    

    if(Auth::attempt($credentials)){
        $Request->session()->regenerate();

        return redirect()->route('dashboard');
    }

    return back()-> withErrors([
        'email' => 'Invalid email or password.',
    ])->onlyInput('email');
}
}
