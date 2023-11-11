<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Game;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;










class UserController extends Controller
{

    public function index()
    {

        $players = User::orderby('succes_rate', 'desc')->select('id', 'name', 'succes_rate', 'rank')->get();
        $this->rank($players);

        return response()->json(['player' => [$players]], 200);
    }

    public function login(Request $request)
    {

        $rules = [
            'email' => 'required|email',
            'password' => 'required',
        ];

        $messages = [
            'email.required' => 'Email is required.',
            'password.required' => 'Please enter a password.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
        $data = [
            'email' => $request->email,
            'password' => $request->password,
        ];
        if (Auth::attempt($data)) {
            $user = Auth::user();
             /** @var \App\Models\User $user **/
            $token = $user->createToken('auth_token')->accessToken;

            return response()->json(['message' => 'Logged in', 'user' => $user->name, 'auth_token' => $token], 200);
        }
        return response()->json(['message' => 'User or password incorrect'], 401);
    }

    public function register(Request $request)
    {
        $rules = [
            'name' => 'nullable',
            'email' => 'required|email',
            'password' => 'required|min:8',
        ];

        $messages = [
            'email.required' => 'The email field is required.',
            'password.min' => 'The length is less than 8.',
            'password.required' => 'The password field is required.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()], 422);
        }
            //verify email
        $existingUser = User::where('name', $request->name)  ->orWhere('email', $request->email) ->first();

        if ($existingUser) {
            return response()->json(['message' => 'Name or email already exists'], 422);
        }

        $name = $request->filled('name') ? $request->name : 'Anonymous';
        $user = User::create([
            'name' => $name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ])->assignRole('player');

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $newName = $request->input('name');

        if ($user->id !== Auth::user()->id) {
            return response()->json(['message' => 'You do not have permission to update this user.'], 401);
        }
        if (empty($newName)) {
            return response()->json(['error' => 'The name field is required.'], 422);
        }
        if ($newName !== $user->name) {
            $validator = Validator::make(['name' => $newName], [
                'name' => 'required|max:55|unique:users,name,',
            ]);

            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()->first()], 422);
            }

            $user->name = $newName;
            $user->save();
        } else {
            return response()->json(['error' => 'The provided name is the same as the current one. No update performed.'], 422);
        }

        return response()->json(['message' => 'Name update', 'name' => $user->name], 200);
    }

    public function logout()
    {
          /** @var \App\Models\USer $user **/
        $user = Auth::user();

        $token = $user->token();
        $token->revoke();

        return response()->json(['message' => 'Successfully logged out'], 200);
    }

    public function  highestSuccessRate()
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'player');
        })->orderBy('succes_rate', 'desc')->first();
        if ($user) {

            $wins = $user->games()->where('win', true)->count();
            return response()->json(['User high rate' => $user->succes_rate, 'name' => $user->name, 'Games wins' => $wins, 'Games played' => $user->games()->count(), 'Date Account' => $user->created_at], 200);
        } else {
            return response()->json(['message' => 'No users found'], 404);
        }
    }
    public function lowestSuccessRate()
    {
        $user = User::whereHas('roles', function ($query) {
            $query->where('name', 'player');
        })
            ->orderBy('succes_rate', 'asc')->first();
        if ($user) {
            $wins = $user->games()->where('win', true)->count();
            return response()->json(['User high rate' => $user->succes_rate, 'name' => $user->name, 'Games wins' => $wins, 'Games played' => $user->games()->count(), 'Date Account' => $user->created_at], 200);
        } else {
            return response()->json(['message' => 'No users found'], 404);
        }
    }


    public function allGamesRate()
    {
        $gamesPlayeds = Game::count();
        $winGames = Game::where('win', true)->count();

        $rate = $gamesPlayeds > 0 ? ($winGames / $gamesPlayeds) * 100 : 0;
        return response()->json(['All games rate' => round($rate, 2), 'Games played' => $gamesPlayeds], 200);
    }
    private function rank($players)
    {
        $rank = 1;
        $users = User::orderby('succes_rate', 'desc');
        foreach ($players as $player) {
            $player->rank = $rank;
            $rank++;
            $player->save();
        }
    }
}
