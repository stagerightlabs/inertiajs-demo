<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Borrowed from:
 * https://github.com/dwightwatson/laravel-auth-tests/blob/master/RegisterTest.php
 */
class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The registration form can be displayed.
     *
     * @return void
     */
    public function test_registration_form_displayed()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * A valid user can be registered.
     *
     * @return void
     */
    public function test_registers_valid_users()
    {
        $user = factory(User::class)->make();

        $response = $this->post('register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertStatus(302);

        $this->assertAuthenticated();
    }

    /**
     * An invalid user is not registered.
     *
     * @return void
     */
    public function test_does_not_register_invalid_users()
    {
        $user = factory(User::class)->make();

        $response = $this->post('register', [
            'name' => $user->name,
            'email' => $user->email,
            'password' => 'secret',
            'password_confirmation' => 'invalid'
        ]);

        $response->assertSessionHasErrors();

        $this->assertGuest();
    }
}
