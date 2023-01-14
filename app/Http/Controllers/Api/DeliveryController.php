<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Delivery;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DeliveryController extends Controller
{
    private const DELIVERY_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $deliveries = Delivery::where('disabled', '=', false)
                            ->paginate(self::DELIVERY_PER_PAGE);

        return response()->json($deliveries, Response::HTTP_OK);
    }
}
