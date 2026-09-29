<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_can_view_login_form(): void
    {
        $response = $this->get(route('login'));

        $response->assertOk()->assertSee('Masukkan email dan kata sandi akun Anda.');
    }

    public function test_guest_can_view_registration_form(): void
    {
        $response = $this->get(route('register'));

        $response->assertOk()->assertSee('Buat akun');
    }

    public function test_registration_creates_a_hashed_user_and_authenticates_them(): void
    {
        $response = $this->post(route('register.store'), [
            'name' => 'Rani Kasir',
            'email' => 'rani@example.test',
            'password' => 'kata-sandi-aman',
            'password_confirmation' => 'kata-sandi-aman',
        ]);

        $response->assertRedirectToRoute('admin.dashboard');
        $this->assertAuthenticated();

        $user = User::query()->where('email', 'rani@example.test')->firstOrFail();

        $this->assertModelExists($user);
        $this->assertTrue(Hash::check('kata-sandi-aman', $user->password));
    }

    public function test_registration_rejects_an_existing_email(): void
    {
        User::factory()->create(['email' => 'rani@example.test']);

        $response = $this->post(route('register.store'), [
            'name' => 'Rani Kasir',
            'email' => 'rani@example.test',
            'password' => 'kata-sandi-aman',
            'password_confirmation' => 'kata-sandi-aman',
        ]);

        $response->assertInvalid(['email']);
        $this->assertGuest();
    }

    public function test_valid_credentials_authenticate_and_redirect_to_dashboard(): void
    {
        $user = User::factory()->create([
            'email' => 'rani@example.test',
            'password' => 'kata-sandi-aman',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'rani@example.test',
            'password' => 'kata-sandi-aman',
        ]);

        $response->assertRedirectToRoute('admin.dashboard');
        $this->assertAuthenticatedAs($user);
    }

    public function test_invalid_credentials_return_an_error_without_authenticating(): void
    {
        User::factory()->create([
            'email' => 'rani@example.test',
            'password' => 'kata-sandi-aman',
        ]);

        $response = $this->post(route('login.store'), [
            'email' => 'rani@example.test',
            'password' => 'salah',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_logout_clears_the_authenticated_session(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('logout'));

        $response->assertRedirectToRoute('login');
        $this->assertGuest();
    }
}
