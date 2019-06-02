<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Borrowed from:
 * https://github.com/dwightwatson/laravel-auth-tests/blob/master/LoginTest.php
 */
class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * The login form can be displayed.
     *
     * @return void
     */
    public function test_login_form_displayed()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * A valid user can be logged in.
     *
     * @return void
     */
    public function test_login_valid_user()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password'
        ]);

        $response->assertStatus(302);

        $this->assertAuthenticatedAs($user);
    }

    /**
     * An invalid user cannot be logged in.
     *
     * @return void
     */
    public function test_does_not_log_in_an_invalid_user()
    {
        $user = factory(User::class)->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'invalid'
        ]);

        $response->assertSessionHasErrors();

        $this->assertGuest();
    }

    /**
     * A logged in user can be logged out.
     *
     * @return void
     */
    public function test_logout_an_authenticated_user()
    {
        $user = factory(User::class)->create();

        $response = $this->actingAs($user)->post('/logout');

        $response->assertStatus(302);

        $this->assertGuest();
    }
}
