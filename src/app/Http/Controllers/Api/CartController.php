<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Cart\AddItemToCartRequest;
use App\Http\Requests\Api\Cart\RemoveItemFromCartRequest;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CartController extends Controller
{
    public function list(Request $request): JsonResponse
    {
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);

        $this->deleteOutOfStockCartItems($cart);
        $cart = $cart->fresh();

        return response()->json($cart, Response::HTTP_OK);
    }

    public function add(AddItemToCartRequest $request): JsonResponse
    {
        $fields = $request->validated();
        $product = Product::findOrFail($fields['product_id']);
        if ($product->stock == 0) {
            return response()->json(['message' => 'Sorry, the product is out of stock',], Response::HTTP_CONFLICT);
        }

        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $this->deleteOutOfStockCartItems($cart);
        $cart = $cart->fresh();
        $hasProductCartItem = false;

        foreach ($cart->items as $item) {
            if ($item->product_id == $fields['product_id']) {
                if ($product->stock < $item->quantity + 1) {
                    return response()->json([
                        'message' => 'Sorry, we have only have ' . $product->stock . ' available stock',
                    ], Response::HTTP_CONFLICT);
                }

                $hasProductCartItem = true;
                $item->quantity++;
                $item->save();
                break;
            }
        }

        if (!$hasProductCartItem) {
            $item = CartItem::create(['quantity' => 1]);
            $cart->items()->save($item);
            $product->cartItems()->save($item);
        }

        $cart = $cart->fresh();
        return response()->json($cart, Response::HTTP_CREATED);
    }

    public function remove(RemoveItemFromCartRequest $request): JsonResponse
    {
        $fields = $request->validated();
        $cart = Cart::firstOrCreate(['user_id' => $request->user()->id]);
        $this->deleteOutOfStockCartItems($cart);
        $cart = $cart->fresh();

        foreach ($cart->items as $item) {
            if ($item->product_id == $fields['product_id']) {
                if ($item->quantity == 1) {
                    $item->delete();
                } else {
                    $item->quantity--;
                    $item->save();
                }

                break;
            }
        }

        $cart = $cart->fresh();
        return response()->json($cart, Response::HTTP_OK);
    }

    private function deleteOutOfStockCartItems(Cart $cart)
    {
        $productIds = $cart->items->pluck('product_id');
        $products = Product::findOrFail($productIds)->keyBy('id');

        $cart->items->each(function ($item) use($products) {
            $product = $products[$item->product_id];
            if ($product->stock == 0) {
                $item->delete();
            }

            if ($product->stock < $item->quantity) {
                $diff = $item->quantity - $product->stock;
                $item->quantity = $item->quantity - $diff;
                $item->save();
            }
        });
    }
}
