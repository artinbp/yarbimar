<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\User\CreateUserRequest;
use App\Http\Requests\Api\Dashboard\User\UpdateUserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use function bcrypt;
use function response;

class UserController extends Controller
{
    private const USERS_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $users = User::paginate(self::USERS_PER_PAGE);

        return response()->json($users, Response::HTTP_OK);
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $role = Role::findOrFail($fields['role']);
        if ($role->name == Role::ROLE_SUPER_ADMIN) {
            return response()->json([
                'message' => 'Creating new user with the super admin role is not allowed'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $fields['password'] = bcrypt($fields['password']);
        $id = 0;
        DB::transaction(function () use ($fields, $role, &$id) {
            $user = User::create($fields);
            $id = $user->id;
            $role->users()->save($user);

            if (isset($fields['addresses']) && !empty($fields['addresses'])) {
                $user->address()->createMany($fields['addresses']);
            }
        });
        $user = User::findOrFail($id);

        return response()->json($user, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $user = User::findOrFail($id);

        return response()->json($user, Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);

        $fields = $request->validated();

        $role = Role::findOrFail($fields['role']);
        if ($role->name == Role::ROLE_SUPER_ADMIN) {
            return response()->json([
                'message' => 'Changing user role to super admin is not allowed'
            ], Response::HTTP_UNAUTHORIZED);
        }

        DB::transaction(function () use ($id, $fields, &$user, $role) {
            if (isset($fields['password']) && !empty($fields['password'])) {
                $fields['password'] = bcrypt($fields['password']);
                $user->tokens()->delete();
            }

            $user->update($fields);

            if (isset($fields['role']) && !empty($fields['role'])) {
                $role->users()->save($user);
            }
        });

        $user = User::findOrFail($id);

        return response()->json($user, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $user = User::findOrFail($id);
        if ($user->hasRole(Role::ROLE_SUPER_ADMIN)) {
            return response()->json([
                'message' => 'User with super admin role can not be deleted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->delete();

        return response()->json(['message' => 'User successfully deleted'], Response::HTTP_OK);
    }
}
