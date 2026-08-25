<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            if ($user->status !== 'active') {
                return redirect()->route('home')->with('google_pending', true);
            }

            Auth::login($user, true);

            return redirect()->route('dashboard');
        }

        $fullName = trim($googleUser->getName() ?: 'Google User');
        $nameParts = preg_split('/\s+/', $fullName);
        $firstName = array_shift($nameParts);
        $lastName = count($nameParts) ? array_pop($nameParts) : $firstName;

        User::create([
            'name' => $fullName,
            'first_name' => $firstName,
            'middle_name' => count($nameParts) ? implode(' ', $nameParts) : null,
            'last_name' => $lastName,
            'email' => $googleUser->getEmail(),
            'email_verified_at' => now(),
            'usergroup' => 'user',
            'password' => Hash::make(Str::random(40)),
            'status' => 'inactive',
        ]);

        return redirect()->route('home')->with('google_pending', true);
    }

    public function login(Request $Request)
    {
        $credentials = $Request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $credentials['status'] = 'active';
    

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

    public function updatePassword(Request $request)
    {
        $validated = $request->validateWithBag('passwordUpdate', [
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if (!Hash::check($validated['current_password'], $request->user()->password)) {
            return back()
                ->withErrors(['current_password' => 'The current password is incorrect.'], 'passwordUpdate')
                ->withInput();
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);

        return back()->with('password_success', 'Your password has been updated successfully.');
    }
}
