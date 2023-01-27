<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Shipping;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShippingMethodController extends Controller
{
    private const DELIVERY_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $shippingMethods = Shipping::where('disabled', '=', false)
                            ->paginate(self::DELIVERY_PER_PAGE);

        return response()->json($shippingMethods, Response::HTTP_OK);
    }
}
