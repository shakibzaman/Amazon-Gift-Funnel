<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ZapierService
{
    protected $endpoint;

    public function __construct()
    {
        $this->endpoint = config('zapier.api_endpoint');
    }

    public function sendData(array $data)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($this->endpoint, $data);

        info('Response is', [$response->body()]);

        return $response->json();
    }
}
