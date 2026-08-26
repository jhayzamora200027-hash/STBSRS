<?php

namespace App\Http\Controllers;

use App\Mail\RegistrationAttemptMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Laravel\Socialite\Facades\Socialite;
use Throwable;

class AuthController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $googleUser = Socialite::driver('google')->user();
        $email = strtolower(trim((string) $googleUser->getEmail()));

        if (str_ends_with($email, '@dswd.gov.ph') === false) {
            return redirect()->route('home')->with('google_rejected', true);
        }

        $user = User::where('email', $email)->first();

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
            'email' => $email,
            'auth_provider' => 'google',
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

    public function register(Request $request)
    {
        $request->merge([
            'email' => strtolower(trim((string) $request->input('email'))),
        ]);

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'regex:/@dswd\.gov\.ph$/'],
            'password' => ['required', 'string', PasswordRule::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ], [
            'email.regex' => 'Only DSWD Staff with a @dswd.gov.ph email address may register.',
        ]);

        $existingUser = User::where('email', $validated['email'])->first();

        if ($existingUser) {
            try {
                Mail::to($existingUser->email)->send(new RegistrationAttemptMail($existingUser->name));
            } catch (Throwable $exception) {
                report($exception);
            }

            return redirect()->route('home')->with('registration_pending', true);
        }

        $fullName = trim(implode(' ', array_filter([
            $validated['first_name'],
            $validated['middle_name'] ?? null,
            $validated['last_name'],
        ])));

        User::create([
            'name' => $fullName,
            'first_name' => $validated['first_name'],
            'middle_name' => $validated['middle_name'] ?? null,
            'last_name' => $validated['last_name'],
            'email' => $validated['email'],
            'auth_provider' => 'local',
            'email_verified_at' => now(),
            'usergroup' => 'user',
            'password' => Hash::make($validated['password']),
            'status' => 'inactive',
        ]);

        return redirect()->route('home')->with('registration_pending', true);
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
            'password' => ['required', 'string', PasswordRule::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
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

    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    public function sendResetLink(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
        ]);

        Password::sendResetLink($credentials);

        return back()->with('status', 'If an account exists for that email address, a password reset link has been sent.');
    }

    public function showResetPasswordForm(Request $request, string $token)
    {
        $email = $request->query('email');
        $user = $email ? User::where('email', $email)->first() : null;

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
            'tokenExpired' => !$user || !$this->isResetTokenValid($user, $token),
        ]);
    }

    private function isResetTokenValid(User $user, string $token): bool
    {
        $record = DB::table(config('auth.passwords.users.table', 'password_reset_tokens'))
            ->where('email', $user->getEmailForPasswordReset())
            ->first();

        return $record !== null
            && $record->created_at !== null
            && !now()->subMinutes(config('auth.passwords.users.expire', 60))->isAfter($record->created_at)
            && Hash::check($token, $record->token);
    }

    public function resetPassword(Request $request)
    {
        $validated = $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'string', PasswordRule::min(8)->mixedCase()->numbers()->symbols(), 'confirmed'],
        ]);

        $status = Password::reset(
            $validated,
            function (User $user, string $password): void {
                $user->forceFill([
                    'password' => Hash::make($password),
                    'remember_token' => Str::random(60),
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('home')->with('password_reset_success', 'Your password has been reset. You can now sign in.');
        }

        return back()->withInput($request->only('email'))
            ->withErrors(['email' => __($status)]);
    }
}
