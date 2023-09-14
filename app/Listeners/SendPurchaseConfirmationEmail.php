<?php

namespace App\Listeners;

use App\Mail\PurchaseConfirmation;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPurchaseConfirmationEmail
{
    public function handle(object $event): void
    {
        $purchase = $event->purchase;

        // send confirmation email with details of the purchase
        Mail::to($purchase->email)->send(new PurchaseConfirmation($purchase));
    }
}
