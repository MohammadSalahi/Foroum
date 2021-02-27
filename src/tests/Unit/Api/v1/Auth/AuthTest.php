<?php

namespace Tests\Unit\Api\v1\Auth;

use App\Http\Controllers\Api\v1\Auth\AuthController;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{

    use RefreshDatabase;

    /**
     * Test a user request to register using API
     */
    public function test_register_should_be_validated()
    {
        $response = $this->postJson(route('auth.register'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test a new user can register using API
     */
    public function test_a_new_user_can_register()
    {
        $response = $this->postJson(route('auth.register'), [
            'name'     => 'Dan Salahi',
            'email'    => 'dev.salahi@gmail.com',
            'password' => '12345678',
        ]);
        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * Test a user request to login using API should be validated
     */
    public function test_login_should_be_validated()
    {
        $response = $this->postJson(route('auth.login'));
        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * Test a new user can register using API
     */
    public function test_a_new_user_can_login_by_correct_credentials()
    {
        $user = factory(User::class)->create();
        $response = $this->postJson(route('auth.login'), [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }


    public function test_show_user_data_if_logged_in()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('auth.user'));
        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test a log out the logged in user.
     */
    public function test_a_logged_in_user_can_logout()
    {
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->postJson(route('auth.logout'));
        $response->assertStatus(Response::HTTP_OK);
    }


}
