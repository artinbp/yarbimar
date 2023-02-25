<?php

namespace App\Http\Controllers\Api;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Auth\LoginRequest;
use App\Http\Requests\Api\Auth\RegisterUserRequest;
use App\Http\Requests\Api\Auth\UpdateUserRequest;
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

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $fields['password'] = bcrypt($fields['password']);
        $token = null;
        DB::transaction(function () use ($fields, &$token) {
            $customerRole = Role::where('name', UserRoleEnum::CUSTOMER)->first();
            if (User::count() == 0) {
                $customerRole = Role::where('name', UserRoleEnum::SUPER_ADMIN)->first();
            }

            $user = User::create($fields);
            $customerRole->users()->save($user);

            if (isset($fields['addresses']) && count($fields['addresses'])) {
                $user->address()->createMany($fields['addresses']);
            }

            $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;
        });

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function update(UpdateUserRequest  $request): JsonResponse
    {
        $fields = $request->validated();

        $user = auth()->user();
        $user->update($fields);
        $user = $user->fresh();

        return response()->json($user, Response::HTTP_OK);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $user = User::where('email', $fields['email'])->first();
        if (!$user || !Hash::check($fields['password'], $user->password)) {
            return response()->json(
                ['message' => __('auth.failed')],
                Response::HTTP_UNAUTHORIZED,
            );
        }

        $token = $user->createToken(self::TOKEN_NAME)->plainTextToken;

        return response()->json(['token' => $token], Response::HTTP_CREATED);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => __('auth.logout')], Response::HTTP_OK);
    }

    public function user(): JsonResponse
    {
        $user = auth()->user();

        return response()->json($user, Response::HTTP_OK);
    }
}
