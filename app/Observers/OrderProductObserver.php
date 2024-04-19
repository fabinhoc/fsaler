<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Models\Inventory;
use App\Models\OrderProduct;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;

class OrderProductObserver implements ShouldHandleEventsAfterCommit
{
    public $afterCommit = true;
    /**
     * Handle the OrderProduct "created" event.
     */
    public function created(OrderProduct $orderProduct): void
    {
        $inventory = Inventory::find($orderProduct->product_id);
        $quantity = $inventory->quantity - $orderProduct->quantity;
        $inventory->update(["quantity" => $quantity]);
    }

    /**
     * Handle the OrderProduct "updated" event.
     */
    public function updated(OrderProduct $orderProduct): void
    {
        if ($orderProduct->isDirty('quantity')) {
            $inventory = Inventory::find($orderProduct->product_id);
            $quantity = $inventory->quantity;

            if ($orderProduct->getOriginal('quantity') > $orderProduct->getAttribute('quantity')) {
                $quantity = $quantity + $orderProduct->quantity;
            } else {
                $quantity = $quantity - $orderProduct->quantity;
            }

            $inventory->update(['quantity'=> $quantity]);
        }
    }

    /**
     * Handle the OrderProduct "deleted" event.
     */
    public function deleted(OrderProduct $orderProduct): void
    {
        //
    }

    /**
     * Handle the OrderProduct "restored" event.
     */
    public function restored(OrderProduct $orderProduct): void
    {
        //
    }

    /**
     * Handle the OrderProduct "force deleted" event.
     */
    public function forceDeleted(OrderProduct $orderProduct): void
    {
        //
    }
}
