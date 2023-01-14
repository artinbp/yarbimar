<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Delivery\CreateDeliveryRequest;
use App\Http\Requests\Api\Dashboard\Delivery\UpdateDeliveryRequest;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{
    public function index(): JsonResponse
    {
        $deliveries = Delivery::all();

        return response()->json($deliveries, Response::HTTP_OK);
    }

    public function create(CreateDeliveryRequest $request)
    {
        $delivery = Delivery::create($request->validated());

        return response()->json($delivery, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $delivery = Delivery::findOrFail($id);

        return response()->json($delivery, Response::HTTP_OK);
    }

    public function update(UpdateDeliveryRequest $request, $id): JsonResponse
    {
        $delivery = Delivery::findOrFail($id);
        $delivery->update($request->validated());
        $delivery = Delivery::findOrFail($id);

        return response()->json($delivery, Response::HTTP_OK);
    }
}
