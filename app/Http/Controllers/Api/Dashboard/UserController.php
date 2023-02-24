<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Enums\UserRoleEnum;
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
        $users = User::latest()->paginate(self::USERS_PER_PAGE);

        return response()->json($users, Response::HTTP_OK);
    }

    public function create(CreateUserRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $role = Role::findOrFail($fields['role']);
        if ($role->name == UserRoleEnum::SUPER_ADMIN) {
            return response()->json(
                ['message' => __('messages.new_user_super_admin_role')],
                Response::HTTP_UNAUTHORIZED,
            );
        }

        $fields['password'] = bcrypt($fields['password']);
        $user = null;
        DB::transaction(function () use ($fields, &$user, $role) {
            $user = User::create($fields);
            $role->users()->save($user);

            if (isset($fields['addresses']) && !empty($fields['addresses'])) {
                $user->address()->createMany($fields['addresses']);
            }

            $user = $user->fresh();
        });

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

        $role = null;
        if (isset($fields['role']) && !empty($fields['role'])) {
            $role = Role::findOrFail($fields['role']);
            if ($role->name == UserRoleEnum::SUPER_ADMIN) {
                return response()->json(
                    ['message' => __('messages.change_role_to_super_admin')],
                    Response::HTTP_UNAUTHORIZED,
                );
            }
        }

        DB::transaction(function () use ($id, $fields, &$user, $role, $request) {
            if (isset($fields['password']) && !empty($fields['password'])) {
                $fields['password'] = bcrypt($fields['password']);
                // TODO: check if the user changing its own password.
//                foreach ($user->tokens() as $token) {
//                    if ($token == $request->user()->currentAccessToken()) {
//                        continue;
//                    }
//                    $token->delete();
//                }

                // $user->tokens()->delete();
            }

            $user->update($fields);

            if ($role != null) {
                $role->users()->save($user);
            }

            $user = $user->fresh();
        });

        return response()->json($user, Response::HTTP_OK);
    }

    public function delete(Request $request, $id): JsonResponse
    {
        $user = User::findOrFail($id);
        if ($user->id == $request->user()->id) {
            return response()->json(
                ['message' => __('messages.user_delete_its_self')],
                Response::HTTP_UNAUTHORIZED,
            );
        }

        if ($user->hasRole(UserRoleEnum::SUPER_ADMIN)) {
            return response()->json(
                ['message' => __('messages.delete_user_with_super_admin_role')],
                Response::HTTP_UNAUTHORIZED,
            );
        }

        $user->delete();

        return response()->json(
            ['message' => __('messages.deleted', ['entity' => __('entity.user')])],
            Response::HTTP_OK
        );
    }
}
