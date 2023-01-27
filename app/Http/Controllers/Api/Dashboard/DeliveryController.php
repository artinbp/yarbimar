<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Shipping\CreateShippingRequest;
use App\Http\Requests\Api\Dashboard\Shipping\UpdateShippingRequest;
use App\Models\Shipping;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{
    private const DELIVERY_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $deliveries = Shipping::paginate(self::DELIVERY_PER_PAGE);

        return response()->json($deliveries, Response::HTTP_OK);
    }

    public function create(CreateShippingRequest $request): JsonResponse
    {
        $delivery = Shipping::create($request->validated());

        return response()->json($delivery, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $delivery = Shipping::findOrFail($id);

        return response()->json($delivery, Response::HTTP_OK);
    }

    public function update(UpdateShippingRequest $request, $id): JsonResponse
    {
        $delivery = Shipping::findOrFail($id);
        $delivery->update($request->validated());
        $delivery = Shipping::findOrFail($id);

        return response()->json($delivery, Response::HTTP_OK);
    }
}
