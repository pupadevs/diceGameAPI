<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Validation\Rules\Exists;
use Spatie\Permission\Models\Role;







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

        $register->assertStatus(201);
    }
    public function test_register_no_name()
    {

        $register = $this->postJson(route('user.register'), [
            'name',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password',
        ]);

        $register->assertStatus(201);
    }
    public function test_register_with_valid_data_name_exists()
    {

        $register = $this->postJson(route('user.register'), [
            'name' => 'player',
            'email' => fake()->unique()->safeEmail(),
            'password' => 'Password',
        ]);

        $register->assertStatus(422);
    }
    public function test_register_for_incorrect_data()
    {

        $badEmailAndPass = $this->postJson(route('user.register'), [
            'name' => 'jhh',
            "email" => "eruerf.@vssv",

        ]);

        $badEmailAndPass->assertStatus(422);
    }

    public function test_register_existing_email()
    {
        $existingEmail = $this->postJson(route('user.register'), [
            'name' => 'jhh',
            'email' => 'player@example.com',
            'password' => '123456789'
        ])->assertStatus(422);
    }

    public function test_login()
    {

        $login = $this->postJson(route('user.login'), [
            'email' => 'player@example.com',
            'password' => '12345678'
        ]);

        $login->assertJsonStructure([
            'message',
            'user',
            'auth_token'
        ])->assertStatus(200);

        // Verificando message
        $login->assertJson([
            'message' => 'Logged in',

        ]);

        // Verificando token
        $login->assertJson([
            'auth_token' => !empty($login->json('auth_token'))
        ]);
    }

    public function test_login_invalid_data()
    {
        $badLogin = $this->postJson(route('user.login'), [
            'email' => 'bad@example.com',
            'password' => '12345678'
        ]);

        $badLogin->assertJson(['message' => 'User or password incorrect'])->assertStatus(401);
    }

    public function test_a_user_can_update_nickname_with_valid_data()
    {

        $player = User::factory()->create();
        $token = $player->createToken('auth_token')->accessToken;


        $player->assignRole('player');

        $updateNAme = fake()->name();

        $response = $this->actingAs($player, 'api')->json('PATCH', route('players.update', ['id' => $player->id]), ['name' => $updateNAme], ['auth_token' =>  $token]);

        $this->assertDatabaseHas('users', ['id' => $player->id, 'name' => $updateNAme]);
        $response->assertStatus(200);
    }
    public function test_a_user_can_update_with_same_name()
    {

        $player = User::factory()->create(['name' => 'existente nombre'])->assignRole('player');

        $token = $player->createToken('auth_token')->accessToken;



        $updateNAme = 'existente nombre';

        $response = $this->actingAs($player, 'api')->json('PATCH', route('players.update', ['id' => $player->id]), ['name' => $updateNAme], ['auth_token' =>  $token]);


        $response->assertStatus(422)->assertJson(['error' => 'The provided name is the same as the current one. No update performed.']);
    }
}
