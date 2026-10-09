<?php

namespace Tests\Feature\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Tests\TestCase;

class FrontendClientIpTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        config(['services.frontend.secret' => 'test-secret']);

        // A tiny route in the "api" group that tells us which IP Laravel sees
        Route::middleware('api')->get('/api/_test-ip', fn (Request $request) => ['ip' => $request->ip()]);
    }

    public function test_the_frontend_can_pass_on_the_visitor_ip_with_the_secret(): void
    {
        $this->getJson('/api/_test-ip', [
            'X-Client-IP' => '203.0.113.7',
            'X-Frontend-Secret' => 'test-secret',
        ])->assertJson(['ip' => '203.0.113.7']);
    }

    public function test_a_client_ip_without_the_secret_is_ignored(): void
    {
        $this->getJson('/api/_test-ip', ['X-Client-IP' => '203.0.113.7'])
            ->assertJson(['ip' => '127.0.0.1']);
    }

    public function test_a_wrong_secret_is_ignored(): void
    {
        $this->getJson('/api/_test-ip', [
            'X-Client-IP' => '203.0.113.7',
            'X-Frontend-Secret' => 'guessed-secret',
        ])->assertJson(['ip' => '127.0.0.1']);
    }

    public function test_a_value_that_is_not_an_ip_is_ignored(): void
    {
        $this->getJson('/api/_test-ip', [
            'X-Client-IP' => 'not-an-ip',
            'X-Frontend-Secret' => 'test-secret',
        ])->assertJson(['ip' => '127.0.0.1']);
    }
}
