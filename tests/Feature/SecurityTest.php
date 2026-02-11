<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Core\Security\SecurityManager;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SecurityTest extends TestCase
{
    /**
     * Test XSS Sanitization
     */
    public function test_xss_sanitization()
    {
        $security = new SecurityManager();
        $unsageInput = '<script>alert("xss")</script><p>Hello</p>';
        $safeInput = $security->sanitizeInput($unsageInput);
        
        $this->assertEquals('Hello', $safeInput);
        $this->assertStringNotContainsString('<script>', $safeInput);
    }

    /**
     * Test Security Headers Middleware
     */
    public function test_security_headers_present()
    {
        $response = $this->get('/');
        
        $response->assertHeader('X-Frame-Options', 'SAMEORIGIN');
        $response->assertHeader('X-Content-Type-Options', 'nosniff');
        $response->assertHeader('X-XSS-Protection', '1; mode=block');
    }

    /**
     * Test Rate Limiting for Login
     */
    public function test_login_rate_limiting()
    {
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', ['email' => 'test@example.com', 'password' => 'wrong']);
        }
        
        $response->assertStatus(429);
    }
}
