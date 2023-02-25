<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Enums\UserRoleEnum;
use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use function response;

class RoleController extends Controller
{
    public function list(): JsonResponse
    {
        $roles = Role::where('name', '!=', UserRoleEnum::SUPER_ADMIN)->get();

        return response()->json($roles, Response::HTTP_OK);
    }
}
