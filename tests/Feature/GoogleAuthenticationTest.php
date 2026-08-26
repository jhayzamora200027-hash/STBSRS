<?php

namespace Tests\Feature;

use App\Mail\AccountApprovedMail;
use App\Mail\RegistrationAttemptMail;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\User as SocialiteUser;
use Tests\TestCase;

class GoogleAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

    }

    public function test_non_dswd_google_account_is_rejected_without_creating_a_user(): void
    {
        Socialite::fake('google', SocialiteUser::fake([
            'id' => 'google-id',
            'name' => 'External User',
            'email' => 'external@example.com',
            'avatar' => null,
        ]));

        $response = $this->get(route('google.callback'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('google_rejected', true);
        $this->assertDatabaseMissing('users', ['email' => 'external@example.com']);
    }

    public function test_dswd_google_account_is_created_pending_approval(): void
    {
        Socialite::fake('google', SocialiteUser::fake([
            'id' => 'google-id',
            'name' => 'DSWD User',
            'email' => 'staff@DSWD.GOV.PH',
            'avatar' => null,
        ]));

        $response = $this->get(route('google.callback'));

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('google_pending', true);
        $this->assertDatabaseHas('users', [
            'email' => 'staff@dswd.gov.ph',
            'status' => 'inactive',
        ]);
    }

    public function test_google_login_can_audit_a_long_callback_url(): void
    {
        $user = User::factory()->create([
            'first_name' => 'Google',
            'last_name' => 'User',
            'email' => 'staff@dswd.gov.ph',
            'usergroup' => 'user',
            'auth_provider' => 'google',
            'status' => 'active',
        ]);

        Socialite::fake('google', SocialiteUser::fake([
            'id' => 'google-id',
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => null,
        ]));

        $response = $this->get(route('google.callback', [
            'state' => str_repeat('state-', 60),
            'code' => str_repeat('code-', 60),
        ]));

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('audit_logs', [
            'event' => 'login',
            'user_id' => $user->id,
        ]);
    }

    public function test_approval_sends_a_new_temporary_password(): void
    {
        Mail::fake();

        $admin = User::factory()->create([
            'first_name' => 'System',
            'last_name' => 'Administrator',
            'usergroup' => 'sysadmin',
            'status' => 'active',
        ]);
        $user = User::factory()->create([
            'first_name' => 'Google',
            'last_name' => 'User',
            'usergroup' => 'user',
            'auth_provider' => 'google',
            'email' => 'staff@dswd.gov.ph',
            'status' => 'inactive',
            'approved_at' => null,
        ]);

        $response = $this->actingAs($admin)->patch(route('users.approve', $user));

        $response->assertSessionHas('approval_success');
        $user->refresh();
        $this->assertSame('active', $user->status);
        $this->assertTrue(Hash::check(
            Mail::sent(AccountApprovedMail::class)->first()->password,
            $user->password,
        ));
        Mail::assertSent(AccountApprovedMail::class, fn (AccountApprovedMail $mail) =>
            $mail->hasTo($user->email)
            && $mail->password !== ''
        );
    }

    public function test_duplicate_registration_sends_a_security_notification_without_changing_account(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'first_name' => 'Existing',
            'last_name' => 'User',
            'usergroup' => 'user',
            'email' => 'staff@dswd.gov.ph',
            'password' => Hash::make('OriginalPassword123!'),
            'status' => 'active',
        ]);
        $originalPassword = $user->password;

        $response = $this->post(route('register'), [
            'first_name' => 'Another',
            'last_name' => 'Person',
            'email' => 'STAFF@DSWD.GOV.PH',
            'password' => 'DifferentPassword123!',
            'password_confirmation' => 'DifferentPassword123!',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('registration_pending', true);
        $response->assertSessionMissing('registration_notice');
        $user->refresh();
        $this->assertSame($originalPassword, $user->password);
        Mail::assertSent(RegistrationAttemptMail::class, fn (RegistrationAttemptMail $mail) =>
            $mail->hasTo($user->email)
        );
    }

    public function test_non_dswd_email_cannot_register(): void
    {
        $response = $this->from(route('home'))->post(route('register'), [
            'first_name' => 'External',
            'last_name' => 'User',
            'email' => 'external@example.com',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
            'registration_form' => '1',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors('email');
        $this->assertDatabaseMissing('users', ['email' => 'external@example.com']);
    }

    public function test_dswd_email_registers_as_pending_approval(): void
    {
        $response = $this->post(route('register'), [
            'first_name' => 'STB',
            'middle_name' => 'Staff',
            'last_name' => 'User',
            'email' => 'STAFF@DSWD.GOV.PH',
            'password' => 'Password123!',
            'password_confirmation' => 'Password123!',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHas('registration_pending', true);
        $this->assertDatabaseHas('users', [
            'name' => 'STB Staff User',
            'email' => 'staff@dswd.gov.ph',
            'status' => 'inactive',
            'approved_at' => null,
        ]);
    }

    public function test_registration_rejects_password_without_required_character_types(): void
    {
        $response = $this->from(route('home'))->post(route('register'), [
            'first_name' => 'STB',
            'last_name' => 'Staff',
            'email' => 'weak@dswd.gov.ph',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('home'));
        $response->assertSessionHasErrors('password');
        $this->assertDatabaseMissing('users', ['email' => 'weak@dswd.gov.ph']);
    }
}