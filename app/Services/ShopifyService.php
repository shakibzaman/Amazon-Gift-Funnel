<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ShopifyService
{
    protected $shopifyDomain;
    protected $apiToken;

    public function __construct()
    {
        $this->shopifyDomain = config('shopify.shopify_domain');
        $this->apiToken = config('shopify.access_token');
    }

    public function findCustomerByEmail($email)
    {
        $response = Http::withHeaders($this->headers())
            ->get("https://{$this->shopifyDomain}/admin/api/2024-07/customers/search.json", [
                'query' => "email:{$email}",
            ]);

        return $this->handleResponse($response);
    }

    public function createCustomer($customerData)
    {
        $response = Http::withHeaders($this->headers())
            ->post("https://{$this->shopifyDomain}/admin/api/2024-07/customers.json", [
                'customer' => $customerData,
            ]);

        return $this->handleResponse($response);
    }

    public function createOrder($orderData)
    {
        $response = Http::withHeaders($this->headers())
            ->post("https://{$this->shopifyDomain}/admin/api/2024-07/orders.json", [
                'order' => $orderData,
            ]);

        return $this->handleResponse($response);
    }

    public function updateOrderShippingAddress($orderId, $shippingAddress)
    {
        info('Request address ==> ', [$shippingAddress]);
        $response = Http::withHeaders($this->headers())
            ->put("https://{$this->shopifyDomain}/admin/api/2024-07/orders/{$orderId}.json", [
                'order' => [
                    'id' => $orderId,
                    'shipping_address' => $shippingAddress,
                ],
            ]);
        info('Update address', [$response]);
        return $this->handleResponse($response);
    }

    protected function headers()
    {
        return [
            'Content-Type' => 'application/json',
            'X-Shopify-Access-Token' => $this->apiToken,
        ];
    }

    protected function handleResponse($response)
    {
        if ($response->failed()) {
            return [
                'success' => false,
                'errors' => $response->json()['errors'] ?? 'An unknown error occurred.',
            ];
        }

        return [
            'success' => true,
            'data' => $response->json(),
        ];
    }
}
