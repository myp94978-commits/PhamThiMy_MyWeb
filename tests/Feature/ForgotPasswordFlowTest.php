<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ForgotPasswordFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_and_reset_flow_works()
    {
        $user = User::create([
            'fullname' => 'Test User',
            'username' => 'testuser',
            'email' => 'test@example.com',
            'password' => Hash::make('oldpassword'),
            'phone' => '0123456789',
            'address' => '123 Test Street',
            'gender' => 1,
            'birthday' => '1990-01-01',
            'role' => 1,
            'status' => 1,
            'remember_token' => null,
        ]);

        $response = $this->post('/admin/forgotpass', ['email' => $user->email]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
        $response->assertSessionHas('reset_link');

        $resetUrl = session('reset_link');
        $this->assertStringContainsString('/admin/reset-password/', $resetUrl);

        $response = $this->get($resetUrl);
        $response->assertStatus(200);
        $response->assertSee('Đặt lại mật khẩu');

        $token = $this->extractTokenFromUrl($resetUrl);

        $response = $this->post('/admin/reset-password', [
            'email' => $user->email,
            'token' => $token,
            'password' => 'newpassword123',
            'password_confirmation' => 'newpassword123',
        ]);

        $response->assertRedirect(route('admin.login'));
        $response->assertSessionHas('success');

        $user->refresh();
        $this->assertTrue(Hash::check('newpassword123', $user->password));
    }

    private function extractTokenFromUrl(string $url): string
    {
        $parts = parse_url($url);
        return trim(basename($parts['path']));
    }
}
