<?php

namespace App\Http\Controllers\Api;

use App\Enums\OrderStatusEnum;
use App\Enums\TransactionStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Order\CalculateOrderCostRequest;
use App\Http\Requests\Api\Order\CreateOrderRequest;
use App\Jobs\CancelAbandonedOrderJob;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Order;
use App\Models\Payment as PaymentModel;
use App\Models\Product;
use App\Models\ShippingMethod;
use App\Models\Transaction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Payment\Facade\Payment;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use function now;
use function response;
use function route;


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

    /**
     * @throws Throwable
     */
    public function create(CreateOrderRequest $request): JsonResponse
    {
        $fields = $request->validated();

        // TODO: check whether the address belongs to the user.
        $address = Address::findOrFail($fields['address_id']);
        if ($address->user_id !== $request->user()->id) {
            return response()->json(['message' => 'There is no such address with given id.'], Response::HTTP_BAD_REQUEST);
        }

        // TODO: check whether the shipping method is disabled or not.
        $shipping = ShippingMethod::findOrFail($fields['shipping_method_id']);
        if ($shipping->disabled) {
            return response()->json(['message' => 'There is no such shipping method with give id'], Response::HTTP_BAD_REQUEST);
        }

        // TODO: check if there is any other active (processing or pending) order
        // going on. if there is any do not allow for creating new one. It should-A
        // complete or cancel the other order before creating new one.

        DB::beginTransaction();

        try {
            $isThereAnyUncompletedOrderExists = Order::where('user_id', '=', $request->user()->id)
                ->whereIn('status', [OrderStatusEnum::PENDING])
                ->exists();
            if ($isThereAnyUncompletedOrderExists) {
                DB::rollBack();

                return response()->json([
                    'message' => 'Sorry, you have to complete or cancel your pending or processing order before creating new one.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $cart = Cart::where(['user_id' => $request->user()->id])->firstOrFail();
            if (count($cart->items) == 0) {
                DB::rollBack();

                return response()->json(['message' => 'Sorry, the cart is empty.'], Response::HTTP_BAD_REQUEST);
            }

            $productIds = $cart->items->pluck('product_id');
            $products = Product::findOrFail($productIds)->keyBy('id');

            $total = 0;
            $invoiceItems = [];
            $orderLine = [];
            $cart->items->each(function ($item) use($products, &$orderLine, &$invoiceItems, &$total) {
                $product = $products[$item->product_id];
                // TODO: let the user know that the his/her cart item is out of stock.
                if ($product->stock == 0) {
                    $item->delete();
                    return;
                }

                // TODO: let user know that there isn't suffice quantity.
                if ($product->stock < $item->quantity) {
                    $diff = $item->quantity - $product->stock;
                    $item->quantity = $item->quantity - $diff;
                    $item->save();
                }

                $product->stock = $product->stock - $item->quantity;
                $product->save();

                $orderLine[$product->id] = [
                    'quantity' => $item->quantity,
                    'price'    => $product->price,
                ];

                $amount = $item->quantity * $product->price;
                $invoiceItem = InvoiceItem::create([
                    'quantity' =>  $item->quantity,
                    'price'    => $product->price,
                    'amount'   => $amount,
                ]);
                $total += $amount;
                $invoiceItems[] = $invoiceItem;
                $invoiceItem->product()->associate($product);
                $invoiceItem->save();

                $item->delete();
            });

            $shippingInvoiceItem = InvoiceItem::create([
                'quantity' => 1,
                'price'    => $shipping->fee,
                'amount'   => $shipping->fee,
            ]);
            $shippingInvoiceItem->shippingMethod()->associate($shipping);
            $invoiceItems[] = $shippingInvoiceItem;
            $total += $shipping->fee;

            $invoice = Invoice::create(['total_amount' => $total]);

            $invoice->invoiceItems()->saveMany($invoiceItems);

            $order = Order::create(['status'  => OrderStatusEnum::PENDING]);
            $order->products()->attach($orderLine);
            $order->invoice()->associate($invoice);
            $request->user()->orders()->save($order);
            $address->orders()->save($order);
            $shipping->orders()->save($order);
            $cart->Delete();

            CancelAbandonedOrderJob::dispatch($order)
                ->delay(now()->addMinutes(15));

            $order = $order->fresh();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($order, Response::HTTP_CREATED);
    }

    public function cost(CalculateOrderCostRequest $request): JsonResponse
    {
        $fields = $request->validated();

        // TODO: check whether the address belongs to the user.
        $address = Address::findOrFail($fields['address_id']);
        if ($address->user_id !== $request->user()->id) {
            return response()->json(['message' => 'There is no such address with given id.'], Response::HTTP_BAD_REQUEST);
        }

        // TODO: check whether the shipping method is disabled or not.
        $shipping = ShippingMethod::findOrFail($fields['shipping_method_id']);
        if ($shipping->disabled) {
            return response()->json(['message' => 'There is no such shipping method with give id'], Response::HTTP_BAD_REQUEST);
        }

        // TODO: check if there is any other active (processing or pending) order
        // going on. if there is any do not allow for creating new one. It should-A
        // complete or cancel the other order before creating new one.

        DB::beginTransaction();

        try {
            $isThereAnyUncompletedOrderExists = Order::where('user_id', '=', $request->user()->id)
                ->whereIn('status', [OrderStatusEnum::PENDING])
                ->exists();
            if ($isThereAnyUncompletedOrderExists) {
                DB::rollBack();

                return response()->json([
                    'message' => 'Sorry, you have to complete or cancel your pending or processing order before creating new one.'],
                    Response::HTTP_BAD_REQUEST
                );
            }

            $cart = Cart::where(['user_id' => $request->user()->id])->firstOrFail();
            if (count($cart->items) == 0) {
                DB::rollBack();

                return response()->json(['message' => 'Sorry, the cart is empty.'], Response::HTTP_BAD_REQUEST);
            }

            $productIds = $cart->items->pluck('product_id');
            $products = Product::findOrFail($productIds)->keyBy('id');

            $total = 0;
            $costs = [];
            $cart->items->each(function ($item) use($products, &$invoiceItems, &$costs, &$total) {
                $product = $products[$item->product_id];
                // TODO: let the user know that the his/her cart item is out of stock.
                if ($product->stock == 0) {
                    $item->delete();
                    return;
                }

                // TODO: let user know that there isn't suffice quantity.
                if ($product->stock < $item->quantity) {
                    $diff = $item->quantity - $product->stock;
                    $item->quantity = $item->quantity - $diff;
                    $item->save();
                }

                $amount = $item->quantity * $product->price;
                $costs[] = [
                    'cost_type' => 'product',
                    'product' => $product,
                    'quantity' =>  $item->quantity,
                    'price'    => $product->price,
                    'amount'   => $amount,
                ];

                $total += $amount;
            });

            $costs[] = [
                'cost_type' => 'shipping',
                'shipping_method' => $shipping,
                'quantity' => 1,
                'price'    => $shipping->fee,
                'amount'   => $shipping->fee,
            ];

            $total += $shipping->fee;

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($costs, Response::HTTP_CREATED);
    }

    public function pay(Request $request, $id): JsonResponse
    {
        $order = Order::with('invoice')
            ->where('user_id', '=', $request->user()->id)
            ->where('status', '=', OrderStatusEnum::PENDING)
            ->where('id', '=', $id)
            ->firstOrFail();

        DB::beginTransaction();
        try {
            $transaction = Transaction::create([
                'amount' => $order->invoice->total_amount,
                'status' => TransactionStatusEnum::PENDING,
            ]);
            $transaction->invoice()->associate($order->invoice);

            $payment = Payment::callbackUrl(route('order.transaction.verify', $transaction->id))
                ->amount($order->invoice->total_amount)
                ->purchase(null,
                    function($driver, $transactionId) use (&$transaction) {
                        $transaction->update([
                            'number' => $transactionId,
                            'provider' => get_class($driver)
                        ]);
                    }
                )->pay()->toJson();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }
        DB::commit();

        return response()->json($payment, Response::HTTP_OK);
    }

    public function verify($transactionId): JsonResponse
    {
        DB::beginTransaction();

        try {
            $transaction = Transaction::with('invoice.order')
                ->where('status', '=', TransactionStatusEnum::PENDING)
                ->where('id', '=', $transactionId)
                ->firstOrFail();

            // TODO: check whether the order is in pending state or invoice hasn't paid already.
            if ($transaction->invoice->order->isPaid()) {
                return response()->json(
                    ['message' => 'Order is already paid.'],
                    Response::HTTP_BAD_REQUEST,
                );
            }

            try {
                $receipt = Payment::amount($transaction->amount)->transactionId($transaction->number)->verify();
            } catch (InvalidPaymentException $e) {
                $transaction->update(['status' => TransactionStatusEnum::FAILED]);
                return response()->json(
                    ['status' => 'failed', 'error' => $e->getMessage()],
                    Response::HTTP_BAD_REQUEST,
                );
            }

            $transaction->update([
                'status' => TransactionStatusEnum::PAID,
                'reference_number' => $receipt->getReferenceId(),
            ]);

            $payment = PaymentModel::create(['amount' => $transaction->amount]);
            $payment->transaction()->associate($transaction);
            $payment->save();

            $invoice = $transaction->invoice;
            $order = $transaction->invoice->order;
            $invoice->payment()->associate($payment);
            $invoice->save();
            $order->update(['status' => OrderStatusEnum::PROCESSING]);
            $order->fresh();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        DB::commit();

        return response()->json([
            'status' => 'OK',
            'reference_number' => $receipt->getReferenceId(),
            'order' => $order,
        ], Response::HTTP_OK);
    }

    public function read(Request $request, $id): JsonResponse
    {
        $order = Order::with('products')
            ->where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)
            ->firstOrFail();

        return response()->json($order, Response::HTTP_OK);
    }

    public function cancel(Request $request, $id): JsonResponse
    {
        $order = Order::where('user_id', '=', $request->user()->id)
            ->where('id', '=', $id)
            ->firstOrFail();

        if ($order->status->isCancelled()) {
            return response()->json([
                'message' => 'Order already cancelled'],
                Response::HTTP_BAD_REQUEST
            );
        }

        if (!$order->status->isPending()) {
            return response()->json([
                'message' => 'Only pending orders can get cancelled'],
                Response::HTTP_BAD_REQUEST
            );
        }

        DB::transaction(function() use($order) {
            $order->update(['status' => OrderStatusEnum::CANCELLED]);

            foreach ($order->products as $product) {
                $product->stock = $product->stock + $product->pivot->quantity;
                $product->save();
            }
        });

        return response()->json(['message' => 'Order cancelled']);
    }
}
