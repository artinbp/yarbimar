<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserApiController extends Controller
{
    private const USERS_PER_PAGE = 8;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:'. join(',', [Role::ROLE_SUPER_ADMIN, Role::ROLE_ADMIN]));
    }

    public function list() {
        $users = User::paginate(self::USERS_PER_PAGE);

        return response()->json($users, Response::HTTP_OK);
    }

    public function create(Request $request) {
        $fields = $request->validate([
            'name'     => ['required', 'filled', 'string'],
            'email'    => ['required', 'filled', 'email', 'unique:users,email'],
            'password' => ['required', 'filled', 'confirmed'],
            'roles.*'  => ['required', 'filled', 'distinct', 'exists:roles,id'],
            'addresses'  => ['required', 'array', 'min:1'],
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

        DB::transaction(function() use($fields) {
            $user = User::create([
                'name'     => $fields['name'],
                'email'    => $fields['email'],
                'password' => bcrypt($fields['password']),
            ]);
            
            $user->roles()->attach($fields['roles']);
            $user->address()->createMany($fields['addresses']);
        });

        return response()->json(['message' => 'User successfully created'], Response::HTTP_CREATED);
    }

    public function read($id) {
        $user = User::findOrFail($id);

        return response()->json($user, Response::HTTP_OK);
    }

    public function update($id, Request $request) {
        $fields = $request->validate([
            'name'     => ['filled', 'string'],
            'email'    => ['filled', 'email'],
            'password' => ['filled', 'confirmed'],
            'roles.*'  => ['filled', 'distinct', 'exists:roles,id'],
        ]);

       $user = User::findOrFail($id);
       $user->update($fields);
       $user->roles()->sync($fields['roles']);

        return response()->json(['User successfully updated'], Response::HTTP_OK);
    }

    public function delete($id) {
        $this->middleware('role:'. join(',', [Role::ROLE_SUPER_ADMIN]));

        $user = User::findOrFail($id);
        if ($user->hasRole(Role::ROLE_SUPER_ADMIN)) {
            return response()->json([
                'message' => 'User with super admin role can not be deleted'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user->destroy();

        return response()->json(['message' => 'User successfully deleted'], Response::HTTP_OK);
    }
}
