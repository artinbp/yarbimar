<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use function bcrypt;
use function response;


class AuthController extends Controller
{
    private const TOKEN_NAME = 'myapptoken';

    public function register(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'username' => ['required', 'filled', 'string', 'unique:users,username'],
            'first_name' => ['required', 'filled', 'string'],
            'last_name' => ['required', 'filled', 'string'],
            'email' => ['required', 'filled', 'email', 'unique:users,email'],
            'password' => ['required', 'filled', 'string', 'confirmed'],
            'addresses' => ['array'],
            'addresses.*.address' => ['required', 'filled', 'string'],
            'addresses.*.state' => ['required', 'filled', 'string'],
            'addresses.*.city' => ['required', 'filled', 'string'],
            'addresses.*.building_number' => ['required', 'filled', 'numeric'],
            'addresses.*.unit_number' => ['filled', 'numeric'],
            'addresses.*.zip_code' => ['required', 'filled', 'string'],
            'addresses.*.receiver_first_name' => ['required', 'filled', 'string'],
            'addresses.*.receiver_last_name' => ['required', 'filled', 'string'],
            'addresses.*.receiver_phone' => ['required', 'filled', 'string'],
        ]);

        $fields['password'] = bcrypt($fields['password']);

        $token = "";
        DB::transaction(function () use ($fields, &$token) {
            $user = User::create($fields);

            $customerRole = Role::where('name', Role::ROLE_CUSTOMER)->first();
            $customerRole->users()->save($user);

            if (isset($fields['addresses']) && count($fields['addresses'])) {
                $user->address()->createMany($fields['addresses']);
            }

            $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;
        });

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function login(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $user = User::where('email', $fields['email'])->first();

        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json([
                'message' => "Bad credentials"
            ], Response::HTTP_UNAUTHORIZED);
        }

        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], Response::HTTP_OK);
    }

    public function user(Request $request): JsonResponse
    {
        $user = $request->user()->with('role')->get();

        return response()->json($user, Response::HTTP_OK);
    }
}
