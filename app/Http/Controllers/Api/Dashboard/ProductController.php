<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\Product\CreateProductRequest;
use App\Http\Requests\Api\Dashboard\Product\UpdateProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use function response;

class ProductController extends Controller
{
    private const PRODUCT_PER_PAGE = 8;

    public function list(Request $request): JsonResponse
    {
        $products = Product::filter($request)->latest()->paginate(self::PRODUCT_PER_PAGE);

        return response()->json($products, Response::HTTP_OK);
    }

    public function create(CreateProductRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $product = null;
        DB::transaction(function () use ($fields, &$product) {
            $product = Product::create($fields);
            $product->categories()->attach($fields['categories'] ?? []);
            $product->media()->attach($fields['media'] ?? []);
            $product->diseases()->attach($fields['diseases'] ?? []);
            $product = $product->fresh();
        });

        return response()->json($product, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $product = Product::findOrFail($id);

        return response()->json($product, Response::HTTP_OK);
    }

    public function update(UpdateProductRequest $request, $id): JsonResponse
    {
        $fields = $request->validated();

        $product = Product::findOrFail($id);
        DB::transaction(function () use (&$product, $fields) {
            $product->update($fields);

            if (isset($fields['categories'])) {
                $product->categories()->sync($fields['categories']);
            }

            if (isset($fields['media'])) {
                $product->media()->sync($fields['media']);
            }

            if (isset($fields['diseases'])) {
                $product->diseases()->sync($fields['diseases']);
            }

            $product = $product->fresh();
        });

        return response()->json($product, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product successfully deleted'], Response::HTTP_OK);
    }
}
