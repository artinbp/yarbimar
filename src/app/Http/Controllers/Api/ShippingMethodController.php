<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\ShippingMethod;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ShippingMethodController extends Controller
{
    private const METHODS_PER_PAGE = 8;

    public function list(): JsonResponse
    {
        $shippingMethods = ShippingMethod::where('disabled', '=', false)
                            ->paginate(self::METHODS_PER_PAGE);

        return response()->json($shippingMethods, Response::HTTP_OK);
    }
}
