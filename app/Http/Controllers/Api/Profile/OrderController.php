<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\Order\CreateOrderRequest;
use App\Jobs\CancelAbandonedOrder;
use App\Models\Address;
use App\Models\ShippingMethod;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use function response;


class OrderController extends Controller
{
    private const ORDER_PER_PAGE = 8;

    public function list(Request $request): JsonResponse
    {
        $orders = Order::where('user_id', '=', $request->user()->id)
            ->filter($request)
            ->latest()
            ->paginate(self::ORDER_PER_PAGE);

        return response()->json($orders, Response::HTTP_OK);
    }

    public function create(CreateOrderRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $products = Product::findOrFail(array_map('intval', array_keys($fields['products'])))->keyBy('id');
        $address = Address::findOrFail($fields['address_id']);
        $shipping = ShippingMethod::findOrFail($fields['shipping_method_id']);

        $errors = [];
        foreach ($fields['products'] as $productID => $productFields) {
            if ($products[$productID]->stock < $productFields['quantity']) {
                $errors[] = [
                    'product_id' => $productID,
                    'type'       => 'quantity_mismatch',
                    'message'    => 'Sorry, we have only ' . $productID[$productID]->stock . ' of ' . $productFields['quantity'] . ' available stock',
                ];
            }

            if ($products[$productID]->price != $productFields['price']) {
                $errors[] = [
                    'product_id' => $productID,
                    'type'       => 'price_change',
                    'message'    => 'Sorry, the price of ' . $products[$productID]->title . ' has changed. Try to order with new price.',
                ];
            }
        }

        if (count($errors) != 0) {
            return response()->json(['errors' => $errors], Response::HTTP_CONFLICT);
        }

        $orderLine = [];
        foreach ($products as $product) {
            $orderLine[$product->id] = [
                'quantity' => $fields['products'][$product->id]['quantity'],
                'price'    => $product->price,
            ];
        }

        $id = 0;
        DB::transaction(function() use($orderLine, $request, $products, $address, $shipping, $fields, &$id) {
            $order = Order::create(['status'  => Order::STATUS_PENDING]);

            foreach ($products as $product) {
                $product->stock = $product->stock - $fields['products'][$product->id]['quantity'];
                $product->save();
            }

            $order->products()->attach($orderLine);
            $request->user()->orders()->save($order);
            $address->orders()->save($order);
            $shipping->orders()->save($order);
            $id = $order->id;
        });

        $order = Order::findOrFail($id);

        CancelAbandonedOrder::dispatch($order)
                        ->delay(now()->addMinutes(1));

        return response()->json($order, Response::HTTP_CREATED);
    }

    public function cost(Request $request): JsonResponse
    {
        $fields = $request->validated();

        $products = Product::findOrFail(array_map('intval', array_keys($fields['products'])))->keyBy('id');
        $address = Address::findOrFail($fields['address_id']);
        $shipping = ShippingMethod::findOrFail($fields['shipping_method_id']);

        $errors = [];
        foreach ($fields['products'] as $productID => $productFields) {
            if ($products[$productID]->stock < $productFields['quantity']) {
                $errors[] = [
                    'product_id' => $productID,
                    'type'       => 'quantity_mismatch',
                    'message'    => 'Sorry, we have only ' . $productID[$productID]->stock . ' of ' . $productFields['quantity'] . ' available stock',
                ];
            }

            if ($products[$productID]->price != $productFields['price']) {
                $errors[] = [
                    'product_id' => $productID,
                    'type'       => 'price_change',
                    'message'    => 'Sorry, the price of ' . $products[$productID]->title . ' has changed. Try to order with new price.',
                ];
            }
        }

        if (count($errors) != 0) {
            return response()->json(['errors' => $errors], Response::HTTP_CONFLICT);
        }
    }

    public function read(Request $request, $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        if ($request->user()->id !== $order->user_id) {
            return response()->json(['message' => 'Record not found.'], Response::HTTP_NOT_FOUND);
        }

        return response()->json($order, Response::HTTP_OK);
    }

    public function cancel(Request $request, $id): JsonResponse
    {
        $order = Order::findOrFail($id);

        if ($request->user()->id !== $order->user_id) {
            return response()->json(['message' => 'Record not found.'], Response::HTTP_NOT_FOUND);
        }

        if ($order->status === Order::STATUS_CANCELLED) {
            return response()->json([
                'message' => 'Order already cancelled'],
                Response::HTTP_BAD_REQUEST
            );
        }

       if ($order->status != Order::STATUS_PENDING) {
            return response()->json([
                'message' => 'Only pending orders can get cancelled'],
                Response::HTTP_BAD_REQUEST
            );
       }

        $order->update(['status' => Order::STATUS_CANCELLED]);

        return response()->json(['message' => 'Order cancelled']);
    }
}
