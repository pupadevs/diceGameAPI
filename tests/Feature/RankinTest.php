<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;


class RankinTest extends TestCase
{

    /**
     * A basic feature test example.
     */

    public function test_admin_can_all_player_with__rate()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($admin, 'api')->json('GET', route('players.index'))->assertStatus(200);
    }
    public function test_admin_can_highest_success_rate()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($admin, 'api')->json('GET', route('rankin.winner'))->assertStatus(200);
    }

    public function test_admin_can_lowest_success_rate()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($admin, 'api')->json('GET', route('ranking.loser'))->assertStatus(200);
    }
    public function test_admin_can_all_games_rate()
    {
        $admin = User::factory()->create()->assignRole('admin');
        $response = $this->actingAs($admin, 'api')->json('GET', route('ranking.index'))->assertStatus(200);
    }
}
