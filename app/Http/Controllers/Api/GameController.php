<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{

    public function index($id)
    {
        $authID = Auth::id();
        if ($id == $authID) {
            $user = User::find($id);
            if ($user->games()->count() > 0) {
                $games = $user->games()->get();
                return response()->json(['Played games' => $games->count(), 'Games' => $games], 200);
            } else {
                return response()->json(['message' => 'You dont have games'], 202);
            }
        }
        return  response()->json(['message' => 'Unathorized user'], 401);
    }
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
            //   $user->succes_rate = User::calculateSuccesRate();
            return response()->json(
                [
                    'name' => $user->name,
                    'dice1' => $game->dice1,
                    'dice2' => $game->dice2,
                    'win' => $game->win ? 'Win😊' : 'Lose😞',
                    'message' => $game->win === true ? '🌟 You re on a winning streak 🌟' : '🍀 Better luck next time 🍀'
                ],
                200
            );
        }
        return    response()->json(['message' => 'Unathorized user'], 401);
    }

    public function destroy($id)
    {
        $authID = Auth::id();
        if ($id == $authID) {
            $user = User::find($id);

            if ($user->games()->count() > 0) {
                $user->games()->delete();
                return response()->json(['message' => ' Delete All Game'], 200);
            } else {
                return response()->json(['message' => 'You dont have games for deleted'], 204);
            }
        }
        return response()->json(['message' => 'Unathorized user'], 401);
    }
}
