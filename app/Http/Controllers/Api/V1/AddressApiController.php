<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressApiController extends Controller
{
    private const ADDRESS_PER_PAGE = 8;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function list(Request $request)
    {
        $address = $request->user()->address()->paginate(self::ADDRESS_PER_PAGE);

        return response()->json($address, Response::HTTP_OK);
    }

    public function create(Request $request)
    {
        $fields = $request->validate([
            'address'           => ['required', 'filled', 'string'],
            'state'             => ['required', 'filled', 'string'],
            'city'              => ['required', 'filled', 'string'],
            'building_number'   => ['required', 'filled', 'numeric'],
            'unit_number'       => ['filled', 'numeric'],
            'zip_code'          => ['required', 'filled', 'numeric'],
            'receiver_first_name' => ['required', 'filled', 'string'],
            'receiver_last_name' => ['required', 'filled', 'string'],
            'receiver_phone'     => ['required',  'filled'],
        ]);

        $address = Address::create($fields);
        $request->user()->address()->save($address);

        return response()->json([
            'message' => 'address successfully created',
            'id'      => $address->id,
        ], Response::HTTP_CREATED);
    }

    public function read(Request $request, $id) {
        $address = Address::where('user_id', '=', $request->user()->id)
                            ->where('id', '=', $id)->firstOrFail();
        
        return response()->json($address, Response::HTTP_OK);
    }

    public function update(Request $request, $id) {
        $address = Address::where('user_id', '=', $request->user()->id)
                            ->where('id', '=', $id)->firstOrFail();

        $fields = $request->validate([
            'address'           => ['filled', 'string'],
            'state'             => ['filled', 'string'],
            'city'              => ['filled', 'string'],
            'building_number'   => ['filled', 'numeric'],
            'unit_number'       => ['filled', 'numeric'],
            'zip_code'          => ['filled', 'numeric'],
            'receiver_first_name' => ['filled', 'string'],
            'receiver_last_name' => ['filled', 'string'],
            'receiver_phone'     => ['filled'],
        ]);

        $address->update($fields);

        return response()->json(['message' => 'Address successfully updated.'], Response::HTTP_OK);
    }

    public function delete(Request $request, $id) {
        $address = Address::where('user_id', '=', $request->user()->id)
                            ->where('id', '=', $id)->firstOrFail();

        $address->delete();

        return response()->json(['message' => 'Address successfully deleted'], Response::HTTP_OK);
    }
}
