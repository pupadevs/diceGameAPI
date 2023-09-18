<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;




class GameControllerTest extends TestCase
{

    /**
     * A basic feature test example.
     */
  public function test_throw_dice_with_valid_user(){
    $player = User::factory()->create()->assignRole('player');
    $token = $player->createToken('auth_token')->accessToken;

    $response = $this->actingAs($player, 'api')->postJson(route('games.throw', $player->id));
    $response->assertStatus(200)->assertJsonStructure([
        'name',
        'dice1',
        'dice2',
        'win',
        'message',

    ]);

  }
  public function test_throw_dice_with_invalid_user(){
    $player = User::factory()->create()->assignRole('player');
    $token = $player->createToken('auth_token')->accessToken;
    $fakeId = 45454;
    $response = $this->actingAs($player, 'api')->postJson(route('games.throw', $fakeId));
    $response->assertStatus(401)->assertJsonStructure([

        'message',

    ])->assertJson([
        'message' => 'Unathorized user',
    ]);

  }

  public function test_get_all_games_specific_player_with_emtpy_games(){
    $player = User::factory()->create()->assignRole('player');

    $token = $player->createToken('auth_token')->accessToken;

    $response = $this->actingAs($player, 'api')->json('GET', route('games.index',  $player->id));
    $response->assertStatus(202)->assertJson(['message' => 'You dont have games']);
  }
  public function test_get_all_games_specific_player(){
    $user = User::find(3);
    $this->actingAs($user);
     $token =   $user->createToken('auth_api')->accessToken;
    // Crear un juego asociado al usuario
  /*   $game = Game::factory()->create(['user_id' => $user->id]); */

    // Llamar a la ruta y recibir la respuesta
    $response = $this->json('GET', route('games.index', $user->id), ['Authorization' => 'Bearer' .$token]);

    // Verificar que la respuesta es 200 OK
    $response->assertStatus(200);

    // Verificar que la respuesta contiene la información esperada
    $response->assertJson([
        'Succes Rate' => $user->succes_rate,
        'Played games' => 1, // Se espera al menos un juego
        'Wins Games' => $game->win ? 1 : 0, // Si el juego es una victoria, debe ser 1, de lo contrario 0
        'Games' => [
            [
                'dice1' => $game->dice1,
                'dice2' => $game->dice2,
                'win' => $game->win,
                'id' => $game->id
            ]
        ]
    ]);


  }
}
