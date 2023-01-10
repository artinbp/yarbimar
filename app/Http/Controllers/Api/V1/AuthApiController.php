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
            'email'    => ['required', 'filled', 'email', 'unique:users,email'],
            'password' => ['required', 'filled', 'string', 'confirmed'],
            'addresses'  => ['array'],
            'addresses.*.address'           => ['required', 'filled', 'string'],
            'addresses.*.state'             => ['required', 'filled', 'string'],
            'addresses.*.city'              => ['required', 'filled', 'string'],
            'addresses.*.building_number'   => ['required', 'filled', 'numeric'],
            'addresses.*.unit_number'       => ['filled', 'numeric'],
            'addresses.*.zip_code'          => ['required', 'filled', 'numeric'],
            'addresses.*.receiver_first_name' => ['required', 'filled', 'string'],
            'addresses.*.receiver_last_name' => ['required', 'filled', 'string'],
            'addresses.*.receiver_phone'     => ['required',  'filled'],
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
            
            if (isset($fields['addresses']) && count($fields['addresses'])) {
                $user->address()->createMany($fields['addresses']);
            }

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
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function logout() {  
        auth()->user()->tokens()->delete();

        return response()->json(['message' => 'Logged out'], Response::HTTP_OK);
    }
}
 