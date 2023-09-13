<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
//Login and register
Route::post('login', [UserController::class, 'login'])->name('user.login');
Route::post('players',[UserController::class,'register'])->name('user.register');

Route::middleware('auth:api')->group(function(){
    //Player

    Route::get('/players',[UserController::class,'index'])->middleware('role:admin')->name('players.index'); //Player list

    Route::patch('/players/{id}',[UserController::class, 'update'])->middleware('role:player')->name('playres.update'); //Update name

    Route::get('player/ranking',[UserController::class,'allPlayerRate'])->middleware('role:admin')->name('ranking.index');//Rank all player

    Route::get('/players/ranking/winner',[])->middleware('role:admin')->name('rankin.winner'); //Highest succes rate

    Route::get('/players/ranking/loser',[])->middleware('role:admin')->name('ranking.loser'); //lowest succes rate

    //Game

    Route::get('/players/{id}/games',[GameController::class, 'index'])->middleware('role:player')->name('games.index'); // Games list

    Route::post('/players/{id}/games',[GameController::class, 'throwDice'])->middleware('role:player')->name('games.throw'); //play game

    Route::delete('/players/íd}/games',[GameController::class, 'destroy'])->middleware('role:player')->name('games.destroy'); //game destroy

    Route::post('logout',[UserController::class, 'logout'])->middleware('role:admin|player')->name('user.logout'); //logout
});
