<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;


class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $password;
    protected $userData;

    public function setUp(): void
    {
        parent::setUp();
        $this->password = 'Very secret';
        $this->userData = [
            'name' => 'John Doe',
            'email' => 'example@mail.test',
            'password' => Hash::make($this->password)
        ];
        $this->user = factory(User::class)->create($this->userData);
    }

    public function testUserRegistrationRoute()
    {
        $response = $this->get(route('register'));
        $response->assertOk();
    }

    public function testUserLoginRoute()
    {
        $response = $this->get(route('login'));
        $response->assertOk();
    }

    public function testUserLogin()
    {
        $response = $this->post(route('login'), array_merge($this->userData, ['password' => $this->password]));
        $response->assertRedirect(route('home'));
    }

    public function testUserLogout()
    {
        $response = $this->actingAs($this->user)->post('logout');
        $response->assertRedirect('/');
    }

    public function testUserShow()
    {
        $response = $this->actingAs($this->user)->get(route('user.show'));
        $response->assertOk();
    }

    public function testUserRegistration()
    {
        $userData = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.test',
            'password' => '123456789',
            'password_confirmation' => '123456789'
        ];
        $response = $this->post(route('register'), $userData);
        $response->assertRedirect(route('home'));
        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email']]);
    }
}
