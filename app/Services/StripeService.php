<?php

namespace App\Services;

use Stripe\Stripe;
use App\Models\Order;
use Stripe\Checkout\Session;

class StripeService
{
    public function __construct()
    {
        Stripe::setApiKey(config('services.stripe.secret'));
    }

    public function createCheckoutSession(Order $order)
    {
        return Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $order->product->name,
                    ],
                    'unit_amount' => $order->amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success', ['order' => $order->id]),
            'cancel_url' => route('payment.cancel', ['order' => $order->id]),
        ]);
    }
}
