<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;


class AuthApiController extends Controller
{
    private const TOKEN_NAME = 'myapptoken';
    
    public function register(Request $request) {
        $fields = $request->validate([
            'name'     => ['required', 'filled', 'string'],
            'email'    => ['required', 'filled', 'string', 'unique:users,email', 'email'],
            'password' => ['required', 'filled', 'string', 'confirmed'],
        ]);

        $token = "";
        DB::transaction(function() use($fields, &$token) {
            $user = User::create([
                'name'     => $fields['name'],
                'email'    => $fields['email'],
                'password' => bcrypt($fields['password']),
            ]);
    
            $customerRole = Role::where('name', Role::ROLE_CUSTOMER)->get();
            $user->roles()->attach($customerRole);

            $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;
        });

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function login(Request $request) {
        $fields = $request->validate([
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response([
                'message' => "Bad credentials"
            ], 401);
        }

        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function logout() {  
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}
 