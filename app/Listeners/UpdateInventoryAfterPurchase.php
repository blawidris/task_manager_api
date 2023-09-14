<?php

namespace App\Listeners;

use App\Models\Product;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class UpdateInventoryAfterPurchase
{
    public function handle(object $event): void
    {
        // update inventory for each item purchased
        $purchase = $event->purchase;

        foreach (json_decode($purchase->item) as $item) {
            Product::find($item->id)->decrement('quantity', $item->quantity);
        }
    }
}
