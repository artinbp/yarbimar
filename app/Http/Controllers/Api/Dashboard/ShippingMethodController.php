<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\ShippingMethod\CreateShippingMethodRequest;
use App\Http\Requests\Api\Dashboard\ShippingMethod\UpdateShippingRequest;
use App\Models\ShippingMethod;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShippingMethodController extends Controller
{
    private const METHODS_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $shippingMethods = ShippingMethod::paginate(self::METHODS_PER_PAGE);

        return response()->json($shippingMethods, Response::HTTP_OK);
    }

    public function create(CreateShippingMethodRequest $request): JsonResponse
    {
        $shippingMethod = ShippingMethod::create($request->validated());

        return response()->json($shippingMethod, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $delivery = ShippingMethod::findOrFail($id);

        return response()->json($delivery, Response::HTTP_OK);
    }

    public function update(UpdateShippingRequest $request, $id): JsonResponse
    {
        $shippingMethod = ShippingMethod::findOrFail($id);
        $shippingMethod->update($request->validated());
        $shippingMethod = $shippingMethod->fresh();

        return response()->json($shippingMethod, Response::HTTP_OK);
    }
}
