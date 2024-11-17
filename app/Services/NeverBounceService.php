<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class NeverBounceService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = config('services.neverbounce.api_key');
    }

    public function validateEmail($email)
    {
        $response = Http::get('https://api.neverbounce.com/v4/single/check', [
            'key' => $this->apiKey,
            'email' => $email,
        ]);
        info('Valid mail Response', [$response]);
        return $response->json();
        info('Valid mail Response Json', [$response->json()]);
    }

    public function getAccountInfo()
    {
        $response = Http::get('https://api.neverbounce.com/v4/account/info', [
            'key' => $this->apiKey,
        ]);
        info('Get account info ', [$response]);
        // Check if the response was successful
        if ($response->successful()) {
            info('Response Json', [$response->json()]);
            $response_json = $response->json();
            info('Credit no ', [$response_json['credits_info']['free_credits_remaining']]);
            return $response_json['credits_info']['free_credits_remaining'];
        } else {
            // Handle error response
            throw new \Exception('Failed to retrieve account info: ' . $response->body());
        }
    }
}
