<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Address\CreateAddressRequest;
use App\Http\Requests\Api\Address\UpdateAddressRequest;
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

    public function create(CreateAddressRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $address = null;
        DB::transaction(function () use ($fields, $request, &$address) {
            $address = Address::create($fields);
            $request->user()->address()->save($address);
            $address = $address->fresh();
        });

        return response()->json($address, Response::HTTP_CREATED);
    }

    public function read(Request $request, $id): JsonResponse
    {
        $address = Address::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)->firstOrFail();

        return response()->json($address, Response::HTTP_OK);
    }

    public function update(UpdateAddressRequest $request, $id): JsonResponse
    {
        $address = Address::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)->firstOrFail();

        $fields = $request->validated();

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
