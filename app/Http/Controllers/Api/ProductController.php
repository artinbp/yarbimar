<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use function response;


class ProductController extends Controller
{
    private const PRODUCT_PER_PAGE = 8;

    public function list(Request $request): JsonResponse
    {
        $products = Product::filter($request)
            ->whereRelation('categories', 'disabled', '=', false)
            ->paginate(self::PRODUCT_PER_PAGE);

        return response()->json($products, Response::HTTP_OK);
    }
}
