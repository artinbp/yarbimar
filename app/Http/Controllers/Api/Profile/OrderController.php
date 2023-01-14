<?php

namespace App\Http\Controllers\Api\Profile;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Profile\Order\CreateOrderRequest;
use App\Jobs\CancelAbandonedOrder;
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
        $orders = Order::filter($request)->paginate(self::ORDER_PER_PAGE);

        return response()->json($orders, Response::HTTP_OK);
    }

    public function create(CreateOrderRequest $request): JsonResponse
    {
        $fields = $request->validated();

        $productQty = collect($fields['products'])->pluck('quantity', 'id');
        $orderLine = [];
        Product::findOrFail($productQty->keys())->map(function($product) use(&$orderLine, $productQty) {
            $orderLine[$product->id] = [
                'quantity' => $productQty[$product->id],
                'price' => $product->price,
            ];
        });

        $id = 0;
        DB::transaction(function() use($orderLine, $request, &$id) {
            $order = Order::create(['status'  => Order::STATUS_PENDING]);

            $order->products()->attach($orderLine);
            $request->user()->orders()->save($order);
            $id = $order->id;
        });

        $order = Order::findOrFail($id);

        CancelAbandonedOrder::dispatch($order)
                        ->delay(now()->addMinutes(15));

        return response()->json($order, Response::HTTP_CREATED);
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

    public function purchase(Request $request, $id): JsonResponse
    {
         $order = Order::findOrFail($id);

        // TODO: check whether the user owns the order
        if ($request->user()->id !== $order->user_id) {
            return response()->json(['message' => 'Record not found.'], Response::HTTP_NOT_FOUND);
        }

        if ($order->status != Order::STATUS_PENDING) {
            return response()->json([
                'message' => 'Only pending orders can get paid'],
                Response::HTTP_BAD_REQUEST
            );
        }

        // if ($order->status != Order::STATUS_UNPAID) {
        //     return response()->json([
        //         'message' => 'Order may already paid or got cancelled'],
        //         Response::HTTP_BAD_REQUEST
        //     );
        // }

        // $invoice = (new Invoice)->amount($order->total);

        // $ti = 0;
        // $response = Payment::purchase(
        //     (new Invoice)->amount(1000),
        //     function($driver, $transactionId) {
        //         // Store transactionId in database.
        //         // We need the transactionId to verify payment in the future.
        //         Payment::create([
        //             'amount' => $order->total,
        //             'provider' => 'dd',
        //             'status'   => Payment::STATUS_UNPAID,
        //         ]);
        //     }
        // )->pay()->toJson();
    }
}
