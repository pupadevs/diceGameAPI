<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    //Pass
    public function test_register_with_valid_data()
    {

        $register = $this->postJson(route('user.register'), [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password',
        ]);


        $register->assertJson(['message' => 'User registered successfully'])->assertStatus(201);
    }
}
