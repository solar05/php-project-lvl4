<?php

namespace Tests\Feature;

use Task_Manager\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;


class UserTest extends TestCase
{
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
        $response = $this->actingAs($this->user)->get(route('users.show', $this->user));
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

    public function testUserDeleting()
    {
        $response = $this->actingAs($this->user)->delete(route('users.destroy', $this->user));
        $response->assertRedirect(route('welcome'));
        $this->assertDatabaseHas('users', [
            'name' => $this->user['name'], 'email' => $this->user['email']
        ]);
    }

    public function testUserUpdate()
    {
        $newUserData = ['name' => 'Jane Doe', 'email' => 'jane@example.test'];
        $response = $this->actingAs($this->user)->patch(route('users.update', $this->user), $newUserData);
        $response->assertRedirect(route('users.show', $this->user));
        $this->assertDatabaseHas('users', [
            'name' => $newUserData['name'],
            'email' => $newUserData['email']
        ]);
    }
}
