<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
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
        $products = Product::filter($request)->paginate(self::PRODUCT_PER_PAGE);

        return response()->json($products, Response::HTTP_OK);
    }

    public function create(Request $request): JsonResponse
    {
        $fields = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'categories.*' => ['required', 'numeric', 'distinct', 'exists:categories,id'],
            'price' => ['required', 'numeric'],
            'discount' => ['numeric', 'min:0', 'max:100'],
            'media.*' => ['filled', 'numeric', 'distinct'],
            'thumbnail_path' => ['required', 'string', 'exists:media,path'],
            'stock' => ['required', 'numeric'],
        ]);

        $product = [];
        DB::transaction(function () use ($fields, &$product) {
            $product = Product::create($fields);
            $product->categories()->attach($fields['categories']);
            $product->media()->attach($fields['media'] ?? []);
            $product = $product->first();
        });

        return response()->json($product, Response::HTTP_CREATED);
    }

    public function read($id): JsonResponse
    {
        $product = Product::findOrFail($id);

        return response()->json($product, Response::HTTP_OK);
    }

    public function update($id, Request $request): JsonResponse
    {
        $fields = $request->validate([
            'title' => ['filled', 'string'],
            'description' => ['filled', 'string'],
            'categories.*' => ['filled', 'numeric', 'distinct', 'exists:categories,id'],
            'price' => ['filled', 'numeric'],
            'discount' => ['numeric', 'min:0', 'max:100'],
            'media.*' => ['url', 'distinct', 'exists:media,id'],
            'thumbnail_path' => ['filled', 'url'],
            'stock' => ['filled', 'numeric'],
        ]);

        $product = Product::findOrFail($id);
        DB::transaction(function () use (&$product, $fields) {
            $product->update($fields);
            $product->media()->sync($fields['media']);
        });
        $product = Product::findOrFail($id);

        return response()->json($product, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product successfully deleted'], Response::HTTP_OK);
    }
}
