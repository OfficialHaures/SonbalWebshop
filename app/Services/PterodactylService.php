<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Order;

class PterodactylService
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.pterodactyl.key');
        $this->baseUrl = config('services.pterodactyl.url');
    }

    public function createServer(Order $order)
    {
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'Application/vnd.pterodactyl.v1+json',
        ])->post($this->baseUrl . '/api/application/servers', [
            'name' => 'Server-' . $order->id,
            'user' => $order->user_id,
            'egg' => 1, // Default egg ID
            'docker_image' => 'ghcr.io/pterodactyl/yolks:java_17',
            'startup' => 'java -Xms128M -Xmx{{SERVER_MEMORY}}M -jar server.jar',
            'environment' => [
                'MINECRAFT_VERSION' => 'latest',
                'SERVER_JARFILE' => 'server.jar',
            ],
            'limits' => [
                'memory' => $order->product->ram,
                'swap' => 0,
                'disk' => $order->product->disk,
                'io' => 500,
                'cpu' => $order->product->cpu
            ],
            'feature_limits' => [
                'databases' => 1,
                'backups' => 1,
            ],
            'allocation' => [
                'default' => 1,
            ],
        ]);

        return $response->json();
    }
}
