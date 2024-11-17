<?php

namespace App\Services;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use GuzzleHttp\Client;

class GorgiasService
{
    protected $apiUrl;
    protected $username;
    protected $password;
    protected $tagName;
    protected $tagId;
    private CustomerRepositoryInterface $customerRepositoryInterface;
    public function __construct(CustomerRepositoryInterface $customerRepositoryInterface)
    {
        $this->apiUrl = config('gorgias.base_api_url');
        $this->username = config('gorgias.username');
        $this->password = config('gorgias.password');
        $this->tagName = config('gorgias.tag_name');
        $this->tagId = config('gorgias.tag_id');
        $this->customerRepositoryInterface = $customerRepositoryInterface;
    }


    public function addTicketToGorgias()
    {
        $customerId = Session::get('customer_id');
        $recommendation = Session::get('recommendation');
        $review = Session::get('review');

        $customer = $this->customerRepositoryInterface->getById($customerId);
        if ($customer) {
            $bodyText = $this->createBodyText($customer, $recommendation, $review);
            info('Body Text', [$bodyText]);
            $ticketData = $this->createTicketData($customer->name, $customer->email, $bodyText);
            info('ticketData Text', [$ticketData]);

            $response = $this->sendRequest($this->apiUrl, $ticketData);
            info('Gorgias ticket create response', [$response]);
            if ($response->successful()) {
                $responseData = $response->json();
                if (isset($responseData['id'])) {
                    info('Ticket created. Ticket ID: ' . $responseData['id']);
                    $this->addTagToTicket($responseData['id']);
                } else {
                    info('Error creating ticket. Response data: ' . json_encode($responseData, JSON_PRETTY_PRINT));
                }
            } else {
                $this->handleError($response);
            }
        }
    }
    protected function createBodyText($customer, $rating, $review)
    {
        return 'Customer name: ' . $customer->name . "\n" .
            'Contact info: ' . $customer->phone . "\n" .
            'Purchased from: ' . config('gorgias.purchased_from') . "\n" .
            'Star rating: ' . $rating . "\n" .
            'Comment left in review: ' . $review;
    }

    protected function createTicketData($name, $email, $bodyText)
    {
        return [
            'subject' => config('gorgias.ticket_subject'),
            'customer' => [
                'email' => $email
            ],
            'messages' => [
                [
                    'sender' => [
                        'email' => 'support@audienhearing.com',
                        'name' => 'Audien Hearing' // Include sender's name
                    ],
                    'body_text' => $bodyText,
                    'channel' => 'email',
                    'from_agent' => false,
                    'via' => 'api',
                    'source' => [
                        'type' => 'email',
                        'from' => [
                            'id' => 7,
                            'name' => 'Audien Hearing',
                            'address' => 'support@audienhearing.com'
                        ],
                        'to' => [
                            [
                                'id' => 8,
                                'name' => $name,
                                'address' => $email
                            ]
                        ]
                    ]
                ]
            ],
            'status' => 'open',
            'via' => 'api'
        ];
    }

    protected function sendRequest($url, $data)
    {
        $encodedCredentials = base64_encode($this->username . ':' . $this->password);

        return Http::withHeaders([
            'Authorization' => 'Basic ' . $encodedCredentials,
            'Content-Type' => 'application/json',
        ])->post($url, $data);
    }

    protected function addTagToTicket($ticketId)
    {
        $client = new Client();
        $encodedCredentials = base64_encode($this->username . ':' . $this->password);

        $ticket_tag = $client->request('POST', $this->apiUrl . '/' . $ticketId . '/tags', [
            'body' => json_encode(['names' => [$this->tagName], 'ids' => [$this->tagId]]),
            'headers' => [
                'Authorization' => 'Basic ' . $encodedCredentials,
                'Content-Type' => 'application/json',
            ],
        ]);

        info('Ticket tage', [$ticket_tag]);
    }
    protected function handleError($response)
    {
        $statusCode = $response->status();
        $body = $response->body();

        // Log error with status code and response body
        info('Error occurred. Status Code: ' . $statusCode . ' Response Body: ' . $body);

        // You can throw an exception if you want to handle it further up the call stack
        // throw new \Exception('HTTP request failed with status code ' . $statusCode . ': ' . $body);
    }
}
