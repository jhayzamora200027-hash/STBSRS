<?php

namespace App\Http\Controllers;

use App\Mail\LoginOtpMail;
use App\Mail\RegistrationAttemptMail;
use App\Models\User;
use App\Services\ActiveDirectoryService;
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
    public function redirectToGoogle(Request $request)
    {
        $request->session()->put('google_popup', true);

        return Socialite::driver('google')
            ->with(['prompt' => 'consent select_account'])
            ->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $isPopup = (bool) $request->session()->pull('google_popup', false);
        $googleUser = $isPopup
            ? Socialite::driver('google')->stateless()->user()
            : Socialite::driver('google')->user();
        $email = strtolower(trim((string) $googleUser->getEmail()));

        if (str_ends_with($email, '@dswd.gov.ph') === false) {
            return $this->googleAuthResponse($isPopup, 'home', 'google_rejected');
        }

        $user = User::where('email', $email)->first();

        if ($user) {
            if ($user->status !== 'active') {
                return $this->googleAuthResponse($isPopup, 'home', 'google_pending');
            }

            Auth::login($user, true);

            return $this->googleAuthResponse($isPopup, 'dashboard');
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

        return $this->googleAuthResponse($isPopup, 'home', 'google_pending');
    }

    private function googleAuthResponse(bool $isPopup, string $route, ?string $sessionKey = null)
    {
        if ($isPopup) {
            if ($sessionKey) {
                session()->flash($sessionKey, true);
            }

            return response()->view('auth.google-popup-complete');
        }

        $response = redirect()->route($route);

        if ($sessionKey) {
            $response->with($sessionKey, true);
        }

        return $response;
    }

    public function login(Request $request, ActiveDirectoryService $activeDirectory)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'max:255', 'not_regex:/@/'],
            'password' => ['required'],
        ]);

        $adResult = $activeDirectory->authenticate(
            trim($credentials['email']),
            $credentials['password'],
        );

        if (! $adResult['success']) {
            return response()->json([
                'success' => false,
                'message' => $adResult['message'],
            ], 401);
        }

        $attributes = $adResult['attributes'] ?? [];
        $adEmail = strtolower(trim((string) ($attributes['mail'] ?? '')));
        $adUpn = strtolower(trim((string) ($attributes['userprincipalname'] ?? '')));
        $adAccount = strtolower(trim((string) ($attributes['samaccountname'] ?? '')));
        $enteredUsername = strtolower(trim($credentials['email']));

        if ($adEmail === '' || filter_var($adEmail, FILTER_VALIDATE_EMAIL) === false) {
            return response()->json([
                'success' => false,
                'message' => 'Your AD account does not have a valid mail attribute. Contact an administrator.',
            ], 422);
        }

        $user = User::query()
            ->when($adEmail !== '', fn ($query) => $query->where('email', $adEmail))
            ->when($adEmail === '' && $adUpn !== '', fn ($query) => $query->where('email', $adUpn))
            ->first();

        if (! $user && $adAccount !== '') {
            $user = User::where('email', $adAccount.'@dswd.gov.ph')->first();
        }

        if (! $user && str_contains($enteredUsername, '@')) {
            $user = User::where('email', $enteredUsername)->first();
        }

        if (! $user) {
            $name = trim((string) ($attributes['displayname'] ?? ''));
            $firstName = trim((string) ($attributes['givenname'] ?? ''));
            $lastName = trim((string) ($attributes['sn'] ?? ''));

            if ($name === '') {
                $name = trim(implode(' ', array_filter([$firstName, $lastName])));
            }

            if ($firstName === '') {
                $nameParts = preg_split('/\s+/', $name, -1, PREG_SPLIT_NO_EMPTY);
                $firstName = $nameParts[0] ?? 'AD User';
                $lastName = $lastName !== '' ? $lastName : ($nameParts[count($nameParts) - 1] ?? $firstName);
            }

            if ($name === '') {
                $name = $adEmail;
            }

            $user = User::create([
                'name' => $name,
                'first_name' => $firstName !== '' ? $firstName : $name,
                'last_name' => $lastName !== '' ? $lastName : $firstName,
                'email' => $adEmail,
                'auth_provider' => 'active_directory',
                'password' => Hash::make(Str::random(40)),
                'usergroup' => 'user',
                'approved_at' => null,
                'status' => 'inactive',
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Your AD account was verified and your iSTaksyon account was submitted for approval.',
            ], 403);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Your iSTaksyon account is not active yet. Contact an administrator.',
            ], 403);
        }

        $otp = (string) random_int(100000, 999999);
        $minutes = 10;

        try {
            Mail::to($adEmail)->send(new LoginOtpMail(
                $user->first_name ?: $user->name,
                $otp,
                $minutes,
            ));
        } catch (Throwable $exception) {
            report($exception);

            return response()->json([
                'success' => false,
                'message' => 'We could not send the verification code to your AD email address. Try again later.',
            ], 503);
        }

        $request->session()->put('ad_login_otp', [
            'user_id' => $user->getKey(),
            'email' => $adEmail,
            'code' => Hash::make($otp),
            'expires_at' => now()->addMinutes($minutes)->timestamp,
        ]);

        return response()->json([
            'success' => false,
            'requires_otp' => true,
            'masked_email' => $this->maskEmail($adEmail),
            'message' => 'A verification code was sent to the email address stored in your AD account.',
        ]);
    }

    public function verifyAdLoginOtp(Request $request)
    {
        $validated = $request->validate([
            'otp' => ['required', 'digits:6'],
        ]);

        $challenge = $request->session()->get('ad_login_otp');

        if (!is_array($challenge) || ($challenge['expires_at'] ?? 0) < now()->timestamp) {
            $request->session()->forget('ad_login_otp');

            return response()->json([
                'success' => false,
                'message' => 'This verification code has expired. Please sign in again.',
            ], 422);
        }

        if (!Hash::check($validated['otp'], $challenge['code'])) {
            return response()->json([
                'success' => false,
                'message' => 'The verification code is incorrect.',
            ], 422);
        }

        $user = User::find($challenge['user_id']);
        $request->session()->forget('ad_login_otp');

        if (!$user || $user->status !== 'active' || strtolower((string) $user->email) !== $challenge['email']) {
            return response()->json([
                'success' => false,
                'message' => 'Your account is no longer available for sign-in. Contact an administrator.',
            ], 403);
        }

        Auth::login($user, true);
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'redirect' => route('dashboard'),
        ]);
    }

    private function maskEmail(string $email): string
    {
        [$localPart, $domain] = array_pad(explode('@', $email, 2), 2, '');
        $visibleCharacters = min(2, strlen($localPart));

        return substr($localPart, 0, $visibleCharacters)
            . str_repeat('*', max(0, strlen($localPart) - $visibleCharacters))
            . ($domain !== '' ? '@'.$domain : '');
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
