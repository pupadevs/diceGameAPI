<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class GameController extends Controller
{
    //
    private function gameLogic()
    {

        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);

        return ([
            'dice1' => $dice1,
            'dice2' => $dice2,
            'win' => $dice1 + $dice2 === 7
        ]);
    }
    public function throwDice($id)
    {
        $authId = Auth::id();
        if ($authId == $id) {
            $user = User::find($id);
            $game = $user->games()->create($this->gameLogic());
            return response()->json(
                [
                    'name' => $user->name,
                    'dice1' => $game->dice1,
                    'dice2' => $game->dice2,
                    'win' => $game->win ? 'Win' : 'Lose',
                    'message' => $game->win === true ? 'Haz ganado' : 'Mas suerte para la proxima'
                ],
                200
            );
        }
        return response()->json(['message' => 'Unathorized user'], 401);
    }
    
}
