<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Dashboard\User\UpdateUserRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    private const ORDER_PER_PAGE = 8;

    public function list(Request $request): JsonResponse
    {
        $orders = Order::filter($request)->paginate(self::ORDER_PER_PAGE);

        return response()->json($orders, Response::HTTP_OK);
    }

    public function read($id): JsonResponse
    {
        $order = Order::with('products')->findOrFail($id);

        return response()->json($order, Response::HTTP_OK);
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        $fields = $request->validated();

        $products = Product::findOrFail($fields['products']);

        $total = 0;
        foreach ($products as $product) {
            $total += $product->selling_price;
        }

        $user = User::findOrFail($id);
        DB::transaction(function() use($order, $user, $fields, $total) {
            $order->update([
                'total'  => $total,
                'status' => $fields['status'] ?? $order->status,
            ]);
            $order->products()->sync($fields['products']);
            $user->orders()->save($order);
        });

        $order = Order::findOrFail($id);

        return response()->json($order, Response::HTTP_OK);
    }

    public function delete($id): JsonResponse
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return response()->json(['message' => 'order successfully deleted'], Response::HTTP_OK);
    }
}
