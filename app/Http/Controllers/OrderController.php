<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Services\StripeService;
use App\Services\PterodactylService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $stripeService;
    protected $pterodactylService;

    public function __construct(StripeService $stripeService, PterodactylService $pterodactylService)
    {
        $this->stripeService = $stripeService;
        $this->pterodactylService = $pterodactylService;
    }

    public function store(Request $request)
    {
        $product = Product::findOrFail($request->product_id);
        
        $order = Order::create([
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'status' => 'pending',
            'amount' => $product->price,
        ]);

        $session = $this->stripeService->createCheckoutSession($order);
        
        return response()->json(['url' => $session->url]);
    }

    public function handleWebhook(Request $request)
    {
        $payload = $request->all();
        
        if ($payload['type'] === 'checkout.session.completed') {
            $order = Order::where('payment_id', $payload['data']['object']['id'])->first();
            $order->status = 'completed';
            $order->save();

            // Create Pterodactyl server
            $serverData = $this->pterodactylService->createServer($order);
            $order->server_id = $serverData['attributes']['id'];
            $order->save();
        }

        return response()->json(['status' => 'success']);
    }
}
