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
            ->latest()
            ->paginate(self::PRODUCT_PER_PAGE);

        return response()->json($products, Response::HTTP_OK);
    }
    public function read(Request $request,$id): JsonResponse
    {
        $products = Product::all()->where('id', '=', $id)->first();


        return response()->json($products, Response::HTTP_OK);
    }
}
