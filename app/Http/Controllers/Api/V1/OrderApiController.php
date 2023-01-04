<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Shetabit\Multipay\Invoice;
use Shetabit\Payment\Facade\Payment as SHPayment;


class OrderApiController extends Controller
{
    private const ORDER_PER_PAGE = 8;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function list() {
        $orders = Order::with('products')->paginate(self::ORDER_PER_PAGE);

        return response()->json($orders, Response::HTTP_OK);
    }
    
    public function create(Request $request) {
        $fields = $request->validate([
            'products.*' => ['required', 'filled', 'numeric', 'distinct', 'exists:products,id'],
        ]);

        $products = Product::find($fields['products']);
    
        $total = 0;
        foreach ($products as $product) {
            $total += $product->selling_price;
        }

        $order = Order::create([
            'total'   => $total,
            'status'  => Order::STATUS_UNPAID,
            'user_id' => $request->user()->id,
        ]);

        $order->products()->attach($fields['products']);

        return response()->json(['id' => $order->id, 'message' => 'Order successfully created'], Response::HTTP_CREATED);
    }

    public function read($id) {
        // TODO: check whether the user owns the order

        $order = Order::with('products')->findOrFail($id);

        return response()->json($order, Response::HTTP_OK);
    }

    public function cancel($id) {
        // TODO: check whether the user owns the order
        $order = Order::findOrFail($id);
       if ($order->status != Order::STATUS_UNPAID) {
            return response()->json([
                'message' => 'Only unpaid orders can get cancelled'],
                Response::HTTP_BAD_REQUEST
            );
       }

        $order->update(['status' => Order::STATUS_CANCELLED]);

        return response()->json(['message' => 'Order cancelled']);
    }

    public function purchase($id) {
        // TODO: check whether the user owns the order

        // $order = Order::findOrFail($id);
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
