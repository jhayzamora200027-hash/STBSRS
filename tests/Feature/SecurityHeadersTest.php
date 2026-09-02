<?php

namespace Tests\Feature;

use Tests\TestCase;

class SecurityHeadersTest extends TestCase
{
    public function test_http_responses_include_security_headers(): void
    {
        $response = $this->get('/');

        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-Frame-Options', 'DENY');
        $response->assertHeader('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->assertHeader('Permissions-Policy', 'camera=(), geolocation=(), microphone=()');
        $response->assertHeader('Content-Security-Policy');
        $response->assertHeaderMissing('Strict-Transport-Security');
    }

    public function test_https_responses_include_hsts(): void
    {
        $response = $this->get('https://localhost/');

        $response->assertHeader(
            'Strict-Transport-Security',
            'max-age=63072000; includeSubDomains'
        );
    }
}