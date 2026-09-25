<?php

namespace App\Http\Controllers;

use App\Models\Customer;

class CardController extends Controller
{
    public function index()
    {
        $customer = Customer::where(
            'customer_id',
            session('customer_id')
        )->first();

        return view(
            'card.index',
            compact('customer')
        );
    }
}