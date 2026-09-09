<?php

namespace Tests\Feature;

use App\Models\User;
use App\Mail\LoginOtpMail;
use App\Services\ActiveDirectoryService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ActiveDirectoryAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_ad_credentials_send_otp_before_logging_in_an_active_local_account(): void
    {
        Mail::fake();

        $user = User::factory()->create([
            'first_name' => 'Juan',
            'last_name' => 'Zamora',
            'email' => 'jpzamora@dswd.gov.ph',
            'usergroup' => 'user',
            'status' => 'active',
        ]);

        $this->app->instance(ActiveDirectoryService::class, new class extends ActiveDirectoryService
        {
            public function authenticate(string $username, string $password): array
            {
                return [
                    'success' => true,
                    'message' => 'Active Directory credentials are valid.',
                    'attributes' => [
                        'mail' => 'jpzamora@dswd.gov.ph',
                        'samaccountname' => 'jpzamora',
                    ],
                ];
            }
        });

        $response = $this->postJson(route('login'), [
            'email' => 'jpzamora',
            'password' => 'correct-password',
        ]);

        $response->assertOk()->assertJson([
            'success' => false,
            'requires_otp' => true,
            'masked_email' => 'jp******@dswd.gov.ph',
        ]);
        $this->assertGuest();

        $otp = null;
        Mail::assertSent(LoginOtpMail::class, function (LoginOtpMail $mail) use (&$otp) {
            $otp = $mail->otp;

            return $mail->hasTo('jpzamora@dswd.gov.ph');
        });

        $challenge = session('ad_login_otp');
        $this->assertIsArray($challenge);
        $this->assertNotNull($otp);
        $this->assertTrue(Hash::check($otp, $challenge['code']));

        $verifyResponse = $this->postJson(route('login.verify-otp'), [
            'otp' => $otp,
        ]);

        $verifyResponse->assertOk()->assertJson([
            'success' => true,
            'redirect' => route('dashboard'),
        ]);
        $this->assertAuthenticatedAs($user);
    }

    public function test_email_address_is_not_accepted_as_an_ad_username(): void
    {
        $response = $this->postJson(route('login'), [
            'email' => 'jpzamora@dswd.gov.ph',
            'password' => 'correct-password',
        ]);

        $response->assertUnprocessable()->assertJsonValidationErrors(['email']);
        $this->assertGuest();
    }

    public function test_valid_ad_credentials_cannot_bypass_inactive_local_account(): void
    {
        User::factory()->create([
            'first_name' => 'Juan',
            'last_name' => 'Zamora',
            'email' => 'jpzamora@dswd.gov.ph',
            'usergroup' => 'user',
            'status' => 'inactive',
        ]);

        $this->app->instance(ActiveDirectoryService::class, new class extends ActiveDirectoryService
        {
            public function authenticate(string $username, string $password): array
            {
                return [
                    'success' => true,
                    'message' => 'Active Directory credentials are valid.',
                    'attributes' => [
                        'mail' => 'jpzamora@dswd.gov.ph',
                    ],
                ];
            }
        });

        $response = $this->postJson(route('login'), [
            'email' => 'jpzamora',
            'password' => 'correct-password',
        ]);

        $response->assertForbidden()->assertJson([
            'success' => false,
            'message' => 'Your iSTaksyon account is not active yet. Contact an administrator.',
        ]);
        $this->assertGuest();
    }

    public function test_valid_ad_credentials_create_a_pending_local_account_when_no_account_exists(): void
    {
        $this->app->instance(ActiveDirectoryService::class, new class extends ActiveDirectoryService
        {
            public function authenticate(string $username, string $password): array
            {
                return [
                    'success' => true,
                    'message' => 'Active Directory credentials are valid.',
                    'attributes' => [
                        'mail' => 'new.user@dswd.gov.ph',
                        'displayname' => 'New User',
                        'givenname' => 'New',
                        'sn' => 'User',
                    ],
                ];
            }
        });

        $response = $this->postJson(route('login'), [
            'email' => 'new.user',
            'password' => 'correct-password',
        ]);

        $response->assertForbidden()->assertJson([
            'success' => false,
            'message' => 'Your AD account was verified and your iSTaksyon account was submitted for approval.',
        ]);

        $this->assertGuest();
        $this->assertDatabaseHas('users', [
            'email' => 'new.user@dswd.gov.ph',
            'auth_provider' => 'active_directory',
            'status' => 'inactive',
            'approved_at' => null,
        ]);
    }
}
