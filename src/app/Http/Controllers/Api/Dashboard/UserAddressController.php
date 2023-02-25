<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\User\Address\CreateUserAddressRequest;
use App\Http\Requests\Api\Dashboard\User\Address\UpdateUserAddressRequest;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class UserAddressController extends Controller
{
    private const ADDRESS_PER_PAGE = 8;

    public function list($id): JsonResponse
    {
        $user = User::findOrFail($id);
        $addresses = $user->address()->paginate(self::ADDRESS_PER_PAGE);

        return response()->json($addresses, Response::HTTP_OK);
    }

    public function create($id, CreateUserAddressRequest $request): JsonResponse
    {
        $user = User::findOrFail($id);
        $fields = $request->validated();

        $address = null;
        DB::transaction(function () use ($fields, $request, &$address, $user) {
            $address = Address::create($fields);
            $user->address()->save($address);
            $address = $address->fresh();
        });

        return response()->json($address, Response::HTTP_CREATED);
    }

    public function read($userId, $addressId): JsonResponse
    {
        $address = Address::where('user_id', '=', $userId)
            ->where('id', '=', $addressId)->firstOrFail();

        return response()->json($address, Response::HTTP_OK);
    }

    public function update($userId, $addressId, UpdateUserAddressRequest $request): JsonResponse
    {
        $address = Address::where('user_id', '=', $userId)
            ->where('id', '=', $addressId)->firstOrFail();

        $fields = $request->validated();

        $address->update($fields);
        $address = $address->fresh();

        return response()->json($address, Response::HTTP_OK);
    }

    public function delete($userId, $addressId): JsonResponse
    {
        $address = Address::where('user_id', '=', $userId)
            ->where('id', '=', $addressId)->firstOrFail();

        $address->delete();

        return response()->json(
            ['message' => __('messages.deleted', ['entity' => __('entity.address')])],
            Response::HTTP_OK
        );
    }
}
