<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use function response;

class AddressController extends Controller
{
    private const ADDRESS_PER_PAGE = 8;

    public function list(Request $request): JsonResponse
    {
        $address = $request->user()->address()->paginate(self::ADDRESS_PER_PAGE);

        return response()->json($address, Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'address' => ['required', 'filled', 'string'],
            'state' => ['required', 'filled', 'string'],
            'city' => ['required', 'filled', 'string'],
            'building_number' => ['required', 'filled', 'numeric'],
            'unit_number' => ['filled', 'numeric'],
            'zip_code' => ['required', 'filled', 'string'],
            'receiver_first_name' => ['required', 'filled', 'string'],
            'receiver_last_name' => ['required', 'filled', 'string'],
            'receiver_phone' => ['required', 'filled', 'string'],
        ]);

        $address = [];
        DB::transaction(function () use ($fields, $request, &$address) {
            $address = Address::create($fields);
            $request->user()->address()->save($address);
        });

        return response()->json($address, Response::HTTP_CREATED);
    }

    public function read(Request $request, $id): JsonResponse
    {
        $address = Address::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)->firstOrFail();

        return response()->json($address, Response::HTTP_OK);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $address = Address::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)->firstOrFail();

        $fields = $request->validate([
            'address' => ['filled', 'string'],
            'state' => ['filled', 'string'],
            'city' => ['filled', 'string'],
            'building_number' => ['filled', 'numeric'],
            'unit_number' => ['filled', 'numeric'],
            'zip_code' => ['filled', 'numeric'],
            'receiver_first_name' => ['filled', 'string'],
            'receiver_last_name' => ['filled', 'string'],
            'receiver_phone' => ['filled'],
        ]);

        $address->update($fields);
        $address = Address::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)->firstOrFail();


        return response()->json($address, Response::HTTP_OK);
    }

    public function delete(Request $request, $id): JsonResponse
    {
        $address = Address::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)->firstOrFail();

        $address->delete();

        return response()->json(['message' => 'Address successfully deleted'], Response::HTTP_OK);
    }
}
