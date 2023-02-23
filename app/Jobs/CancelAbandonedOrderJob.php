<?php

namespace App\Jobs;

use App\Enums\OrderStatusEnum;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class CancelAbandonedOrder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * The order instance
     *
     * @var Order
     */
    private Order $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(): void
    {
        DB::transaction(function() {
            // refresh order instance with new data.
            $order = Order::find($this->order->id);
            if (!$order) {
                return;
            }

            if ($order->status === OrderStatusEnum::PENDING) {
                $order->update(['status' => OrderStatusEnum::CANCELLED]);
                // TODO: plush stock.

                foreach ($order->products as $product) {
                    $product->stock = $product->stock + $product->pivot->quantity;
                    $product->save();
                }
            }
        });
    }
}
