<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Models\Order;

class OrderObserver
{
    /**
     * Handle the Order "created" event.
     */
    public function created(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated(Order $order): void
    {
        if($order->isDirty('status') && $order->status === OrderStatusEnum::CANCELLED) {
            foreach ($order->orderProducts as $orderProduct) {
                $quantity = $orderProduct->product->inventory->quantity + $orderProduct->quantity;
                $orderProduct->product->inventory->quantity = $quantity;
                $orderProduct->product->inventory->save();
            }
        }
    }

    public function saved(Order $order): void
    {
        if($order->isDirty('status') && $order->status === OrderStatusEnum::CANCELLED) {
            foreach ($order->orderProducts as $orderProduct) {
                $quantity = $orderProduct->product->inventory->quantity + $orderProduct->quantity;
                $orderProduct->product->inventory->quantity = $quantity;
                $orderProduct->product->inventory->save();
            }
        }
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored(Order $order): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted(Order $order): void
    {
        //
    }
}
