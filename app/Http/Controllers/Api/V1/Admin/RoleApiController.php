<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RoleApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:'. join(',', [Role::ROLE_SUPER_ADMIN, Role::ROLE_ADMIN]));
    }

    public function list() {
        $roles = Role::all();

        return response()->json($roles, Response::HTTP_OK);
    }
}
