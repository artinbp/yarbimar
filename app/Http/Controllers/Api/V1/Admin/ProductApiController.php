<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class ProductApiController extends Controller
{
    private const PRODUCT_PER_PAGE = 8;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
        $this->middleware('role:'. join(',', [Role::ROLE_SUPER_ADMIN, Role::ROLE_ADMIN]));
    }

    public function list(Request $request) {
        $products = Product::filter($request)->with(['media', 'categories'])->paginate(self::PRODUCT_PER_PAGE);

        return response()->json($products, Response::HTTP_OK);
    }

    public function create(Request $request) {
        $fields = $request->validate([
            'title'          => ['required', 'string'],
            'description'    => ['required', 'string'],
            'categories.*'   => ['required', 'numeric', 'distinct', 'exists:categories,id'],
            'price'          => ['required', 'numeric'],
            'discount'       => ['numeric', 'min:0', 'max:100'],
            'media.*'        => ['filled', 'numeric', 'distinct'],
            'thumbnail_path' => ['required', 'string', 'exists:media,path'],
            'stock'          => ['required', 'numeric'],
        ]);

        $product = Product::create($fields);
        $product->categories()->attach($fields['categories']);
        $product->media()->attach($fields['media'] ?? []);

        return response()->json([
            'id'      => $product->id,
            'message' => 'Product successfully created',
        ], Response::HTTP_CREATED);
    }

    public function read($id) {
        $product = Product::with(['media', 'categories'])->findOrFail($id);

        return response()->json($product, Response::HTTP_OK);
    }

    public function update($id, Request $request) {
        $fields = $request->validate([
            'title'          => ['filled', 'string'],
            'description'    => ['filled', 'string'],
            'categories.*'   => ['filled', 'numeric', 'distinct', 'exists:categories,id'],
            'price'          => ['filled', 'numeric'],
            'discount'       => ['numeric', 'min:0', 'max:100'],
            'media.*'        => ['url', 'distinct', 'exists:media,id'],
            'thumbnail_path' => ['filled', 'url'],
            'stock'          => ['filled', 'numeric'],
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());
        $product->media()->sync($fields['media']);

        return response()->json(['message' => 'Product successfully updated'], Response::HTTP_OK);
    }

    public function delete($id) {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Product successfully deleted'], Response::HTTP_OK);
    }
}
