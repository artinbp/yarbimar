<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Product;


class ProductApiController extends Controller
{
    private const PRODUCT_PER_PAGE = 8;

    public function list(Request $request) {
        $products = Product::filter($request)->paginate(self::PRODUCT_PER_PAGE);

        return response()->json($products, Response::HTTP_OK);
    }
}
