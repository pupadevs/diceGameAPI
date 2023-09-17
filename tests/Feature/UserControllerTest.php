<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;





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
    public function test_register_for_incorrect_dates(){

        $badEmailAndPass = $this->postJson(route('user.register'),[
            'name' => 'jhh',
            "email" => "eruerf.@vssv",

        ]);

        $badEmailAndPass->assertStatus(422);

    }

    public function test_existing_email(){
        $existingEmail = $this->postJson(route('user.register'),[
            'name' => 'jhh',
            'email' => 'prueba232@gmail.com',
            'password' =>'123456789'
        ])->assertStatus(422);

    }
    public function test_existing_name(){
        $existingEmail = $this->postJson(route('user.register'),[
            'name' => 'pupa',
            'email' => 'prueba232@gmail.com',
            'password' =>'123456789'
        ])->assertStatus(422);

    }


    public function test_login()
    {

        $login = $this->postJson(route('user.login'), [
            'email' => 'test@example.com',
            'password' => '12345678'
        ]);

        $login->assertJsonStructure([
            'message',
            'user',
            'auth_token'
        ])->assertStatus(200);

        // Verificando message
        $login->assertJson([
            'message' => 'Logged in'
        ]);

        // Verificando token
        $login->assertJson([
            'auth_token' => !empty($login->json('auth_token'))
        ]);
    }




}
