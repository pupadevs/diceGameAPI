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
    public function test_throw_dice_with_valid_user()
    {
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
    public function test_throw_dice_with_invalid_user()
    {
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

    public function test_get_all_games_specific_player_with_emtpy_games()
    {
        $player = User::factory()->create()->assignRole('player');

        $token = $player->createToken('auth_token')->accessToken;

        $response = $this->actingAs($player, 'api')->json('GET', route('games.index',  $player->id));
        $response->assertStatus(202)->assertJson(['message' => 'You dont have games']);
    }
    public function test_get_all_games_specific_player()
    {
        $player = User::factory()->create()->assignRole('player');

        Game::factory(5)->create(['user_id' => $player->id]);
        $token = $player->createToken('auth_token')->accessToken;
        $response = $this->actingAs($player, 'api')->getJson(route('games.index', $player->id), ['Authorization' => 'Bearer' . $token]);
        $response->assertStatus(200);
    }


    public function test_get_all_games_specific_player_invalid_user()
    {
        $player = User::factory()->create()->assignRole('player');

        $response = $this->actingAs($player, 'api')->getJson(route('games.index', 5));

        $response->assertStatus(401)->assertJson(['message' => 'Unathorized user']);
    }

    public function test_delete_all_games()
    {
        $player = User::factory()->create()->assignRole('player');

        Game::factory(5)->create(['user_id' => $player->id]);

        $response = $this->actingAs($player, 'api')->deleteJson(route('games.destroy', $player->id));
        $response->assertStatus(200)->assertJson(['message' => ' Deleted all Games']);
        $this->assertEquals(0, $player->games()->count());
    }
    public function test_can_delete_all_games_another_user()
    {
        $player = User::factory()->create()->assignRole('player');

        Game::factory(5)->create(['user_id' => $player->id]);

        $response = $this->actingAs($player, 'api')->deleteJson(route('games.destroy', $player->id + 2));
        $response->assertStatus(401);
        $this->assertEquals(5, $player->games()->count());
    }
    public function test_delete_all_games_empty()
    {
        $player = User::factory()->create()->assignRole('player');
        $response = $this->actingAs($player, 'api')->deleteJson(route('games.destroy', $player->id));
        $response->assertStatus(204);
    }
}
