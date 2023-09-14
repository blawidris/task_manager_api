<?php

namespace App\Http\Controllers;

use App\Events\PurchaseSuccessful;
use App\Models\Purchase;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('pages.summary');
    }


    public function purchase(Request $request)
    {
        // process purchase

        // create a new Purchase Model
        $purchase = Purchase::create($request->only([
            'first_name',
            "last_name",
            "email",
            "address",
            "city",
            "zip_code",
            "items"
        ]));

        // return $request->all();

        // send confirmation email

        // update inventory
        PurchaseSuccessful::dispatch($purchase);
    }
}