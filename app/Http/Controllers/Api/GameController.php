<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Auth;



use Illuminate\Http\Request;

class GameController extends Controller
{
    //
    private function gameLogic(){

        $dice1 = rand(1,6);
        $dice2 = rand(1,6);

        return ([
            'dice1' => $dice1,
            'dice2' => $dice2,
            'win' => $dice1 + $dice2 === 7
        ]);
    }
   
}
