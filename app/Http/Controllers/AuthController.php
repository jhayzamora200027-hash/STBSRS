<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        return response()->json([
            'success' => true,
            'redirect' => route('dashboard')
        ]);

    }

    return response()->json([
        'success' => false,
        'message' => 'Invalid email or password'
    ],401);
}

    public function logout(Request $request){
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
