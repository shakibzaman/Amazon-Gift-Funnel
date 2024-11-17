<?php

namespace App\Http\Controllers\Order;

use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerOrderCheckRequest;
use App\Http\Requests\StoreReviewRequest;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\ReviewRepositoryInterface;
use App\Models\Customer;
use App\Models\CustomerOrder;
use App\Services\GorgiasService;
use App\Services\ShopifyService;
use DateTime;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;

use function App\Helpers\validateStep;

class OrderController extends Controller
{
    protected $baseUrl;
    protected $customer;
    protected $credentials;
    protected $inboxId;
    protected $client;
    protected $shopifyService;
    protected $gorgiasService;

    private OrderRepositoryInterface $orderRepositoryInterface;
    private ReviewRepositoryInterface $reviewRepositoryInterface;
    private CustomerRepositoryInterface $customerRepositoryInterface;
    public function __construct(
        OrderRepositoryInterface $orderRepositoryInterface,
        ReviewRepositoryInterface $reviewRepositoryInterface,
        CustomerRepositoryInterface $customerRepositoryInterface,
        ShopifyService $shopifyService,
        GorgiasService $gorgiasService
    ) {
        $this->client = new Client();
        $this->orderRepositoryInterface = $orderRepositoryInterface;
        $this->reviewRepositoryInterface = $reviewRepositoryInterface;
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->shopifyService = $shopifyService;
        $this->gorgiasService = $gorgiasService;

        $this->baseUrl = 'https://audienhearing.gorgias.com/api';
        $this->credentials = base64_encode(env('GORGIAS_API_USERNAME') . ':' . env('GORGIAS_API_PASSWORD'));
        $this->inboxId = env('VOC_TIGER_TEAM_INBOX_ID');
    }
    public function checkOrderPage()
    {
        $stepValidate = validateStep();

        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        return view('public.check-order');
    }
    public function checkingOrder(CustomerOrderCheckRequest $request)
    {
        $stepValidate = validateStep();
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        $hasFunnel = false;

        if (config('app.order_test_mode')) {
            echo "You are in test mode now";
            // Have to write code 
        }

        $customerId = Session::get('customer_id');

        $searchType = (int) $request->search_type;
        $orderId = preg_replace('/[^a-zA-Z0-9_-]/', ' ', $request->order_id);
        session(['order_id' => $orderId]);
        $api = intval($searchType);
        info('orderId -1', [$orderId]);

        $order = CustomerOrder::where('order_no', $orderId)->first();
        $customer = Customer::where('id', $customerId)->first();
        info('order data -1', [$order]);

        if (!$customer) {
            return ['status' => 404, 'message' => 'Customer Details Not Found'];
        }

        // Order Already Requested
        if ($order && $order->delievered == 1) {
            return redirect()->route('order.already-requested');
        }

        if ($searchType == config('app.order_type.amazon')) {
            $orderDetails = $this->getAmazonOrders($orderId);
            if ($orderDetails['status'] != 200) {
                return ['status' => $orderDetails['status'], 'message' => $orderDetails['orders']];
            }
            info('orderDetails', [$orderDetails]);
            $orderItems = $orderDetails['orders']->data->items;
            $purchaseDate = $orderDetails['orders']->data->purchase_date;
            $selectedAsinList = config('amazon.amazon_asin');

            foreach ($orderItems as $item) {
                if (in_array($item->asin, $selectedAsinList)) {
                    $matchingAsin = $item->asin;
                    $customer->update(['product_asin' => $matchingAsin]);
                    $hasFunnel = true;
                    break;
                }
            }

            if (!$hasFunnel) {
                return ['status' => 404, 'message' => 'No matching ASIN found'];
            }
        }

        if ($hasFunnel) {
            $orderData = ['customer_id' => $customerId, 'order_no' => $orderId, 'api' => $api];
            // Customer Order Create or Update 
            CustomerOrder::updateOrCreate($orderData, $orderData);

            if (isset($purchaseDate)) {
                // $today = new DateTime();
                // $purchaseDate = new DateTime($purchaseDate);
                // $purchaseDate->modify('+7 days');

                // if ($today > $purchaseDate) {
                $customer = [
                    'funnel_step' => config('app.funnel_step.step_2')
                ];
                // Update Customer Data 
                $this->customerRepositoryInterface->update($customer, $customerId);
                session(['too_soon_flag' => true, 'funnel_step' => config('app.funnel_step.step_2')]);
                return redirect()->route('order.survey.second-step');
                // } else {
                //     session(['funnel_step' => config('app.funnel_step.step_1')]);
                //     session(['too_soon_flag' => false]);
                //     return redirect()->route('order.too-soon');
                // }
            } else {
                return redirect()->route('order.order-not-found');
            }
        } else {
            return redirect()->route('order.order-not-found');
        }
    }

    public function test()
    {
        dd(session()->all());
        return $this->customerRepositoryInterface->getByEmail('vpbanker@aol.com');
        return validateStep();
    }
    public function orderAlreadyRequested()
    {
        return view('public.already-requested');
    }
    public function surveyStep2()
    {
        $stepValidate = validateStep(config('app.funnel_step.step_2'));
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        return view('public.survey-step-2');
    }

    public function orderSurveyAction(StoreReviewRequest $request)
    {
        $customerId = Session::get('customer_id');
        $stepValidate = validateStep(config('app.funnel_step.step_2'));
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        $details = [
            'review' => $request->review,
            'satisfaction' => $request->satisfaction,
            'recommendation' => $request->recommendation,
            'customer_id' => $customerId
        ];
        $review = $this->reviewRepositoryInterface->store($details);
        info('review', [$review]);
        $customer = [
            'funnel_step' => config('app.funnel_step.step_3')
        ];
        $update_step = $this->customerRepositoryInterface->update($customer, $customerId);
        session(['funnel_step' => config('app.funnel_step.step_3')]);
        info('update_step', [$update_step]);

        // Add data to session for further use 
        session(['review' => $request->review]);
        session(['recommendation' => $request->recommendation]);

        return $this->_surveryRedirectPage($request);
    }
    private function _surveryRedirectPage($request)
    {
        $satisfaction = $request->satisfaction;
        $recommendation = $request->recommendation;

        $positiveSatisfaction = [
            config('app.review_satisfiction.like'),
            config('app.review_satisfiction.love')
        ];

        if (in_array($satisfaction, $positiveSatisfaction) && in_array($recommendation, [4, 5])) {
            return redirect()->route('order.share_review');
        }
        return redirect()->route('order.update_address');
    }
    public function tooSoon()
    {
        return view('public.too-soon');
    }
    public function orderNotFound()
    {
        return view('public.order-not-found');
    }
    public function orderUpdateAddress()
    {
        $customerId = Session::get('customer_id');
        $stepValidate = validateStep(config('app.funnel_step.step_3')) || validateStep(config('app.funnel_step.step_4'));
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        $customer = $this->customerRepositoryInterface->getById($customerId);
        return view('public.update-address', compact('customer'));
    }
    public function storeOrderAddress(Request $request)
    {
        $customerId = Session::get('customer_id');

        $stepValidate = validateStep(config('app.funnel_step.step_3')) || validateStep(config('app.funnel_step.step_4'));
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        $details = [
            'name'         => $request->full_name,
            'address'     => $request->full_address,
            'city'         => $request->city,
            'state'     => $request->state,
            'phone'     => $request->phone,
            'zip'         => $request->zip,
            'country'   => $request->country,
            'funnel_step' => config('app.funnel_step.step_4')
        ];
        $customerUpdate = $this->customerRepositoryInterface->update($details, $customerId);
        session(['funnel_step' => config('app.funnel_step.step_4')]);
        info('customerUpdate', [$customerUpdate]);
        if ($customerUpdate) {
            return redirect(url('confirm-address'));
        }
    }
    public function confirmAddress()
    {
        $customerId = Session::get('customer_id');
        $stepValidate = validateStep(config('app.funnel_step.step_4'));
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        $customer = $this->customerRepositoryInterface->getById($customerId);
        return view('public.confirm-address', compact('customer'));
    }
    public function shipProduct()
    {
        $customerId = Session::get('customer_id');

        $stepValidate = validateStep(config('app.funnel_step.step_4'));
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }

        $orderId = Session::get('order_id');
        $order = CustomerOrder::where('order_no', $orderId)->first();
        $customer = $this->customerRepositoryInterface->getById($customerId);

        // Already Delivered
        if ($order && $order->delivered == 1) {
            return redirect()->route('order.thankyou');
        }

        //    Shopify Service to create a order 

        $create_shopify_order = $this->createOrder($customer);
        info('Create Shopify Order', [$create_shopify_order]);
        if ($create_shopify_order['status'] == 400) {
            if (isset($create_shopify_order['errors']['shipping_address']) && !empty($create_shopify_order['errors']['shipping_address'])) {
                // Extract the first error message, or provide a default message
                $errorMessage = $create_shopify_order['errors']['shipping_address'][0] ?? 'An error occurred with the shipping address.';
                info('Error message', [$errorMessage]);
                // Store the error message in a flash session
                session()->flash('error', $errorMessage);
                return redirect()->back(); // Redirect back to the previous page
            }
        } else {
            // Add ticket to gorgias & Ticket assign to chat group 
            if (config('gorgias.service')) {
                $gorgias_service = $this->gorgiasService->addTicketToGorgias();
                info('Gorgias Service', [$gorgias_service]);
            }
            $this->customerRepositoryInterface->update(
                ['funnel_step' => config('app.funnel_step.step_5')],
                $customerId
            );
            $update_data =  $this->orderRepositoryInterface->update(['delievered' => 1], $order->id);
            info('Update data', [$update_data]);
            session(['funnel_step' => config('app.funnel_step.step_5')]);
            return redirect(url('thank-you'));
        }
    }
    public function thankYou()
    {

        $stepsValidate = validateStep(config('app.funnel_step.step_4')) || validateStep(config('app.funnel_step.step_5'));
        info('Steps', [$stepsValidate]);

        if (!$stepsValidate) {
            return redirect()->route('homepage');
        }
        return view('public.thankyou');
    }

    public function createOrder($customer)
    {
        $orderId = Session::get('order_id');
        $customerData = $this->shopifyService->findCustomerByEmail($customer->email);
        $shopify_customer_id = $customerData['data']['customers'][0]['id'] ?? null;;

        if (is_null($shopify_customer_id)) {
            $customerData = [
                'first_name' => $customer->name,
                'last_name' => $customer->name,
                'email' => $customer->email,
                'verified_email' => true,
                'addresses' => [[
                    'address1' => $customer->address,
                    'city' => $customer->city,
                    'province' => $customer->state,
                    'phone' => $customer->phone,
                    'zip' => $customer->zip,
                    'last_name' => '',
                    'first_name' => $customer->name,
                    'country' => $customer->country,
                ]],
            ];

            $createdCustomer = $this->shopifyService->createCustomer($customerData);
            if (!$createdCustomer['success']) {
                // Handle customer creation error
                info('Create Customer Error', [$createdCustomer['errors']]);
                return redirect()->route('confirm-address');
            }
            $shopify_customer_id = $createdCustomer['data']['customer']['id'];
            $this->customerRepositoryInterface->updateByEmail(
                ['shopify_customer_id' => $shopify_customer_id],
                $customer->email
            );
        }

        $orderData = [
            'line_items' => [[
                'variant_id' => config('shopify.order_variant_id'),
                'name' => config('shopify.order_product_name'),
                'title' => config('shopify.order_product_title'),
                'quantity' => 1,
                'price' => '0',
            ]],
            'customer' => [
                'id' => $shopify_customer_id,
            ],
        ];

        $createdOrder = $this->shopifyService->createOrder($orderData);
        if (!$createdOrder['success']) {
            info('Error when create Order', [$createdOrder['errors']]);
            // return response()->json(['error' => $createdOrder['errors']], 400);
            return redirect()->route('confirm-address');
        }

        $shopifyOrderId = $createdOrder['data']['order']['id'];;
        $shopifyOrderNumber = $createdOrder['data']['order']['order_number'];

        CustomerOrder::where('order_no', $orderId)
            ->where('customer_id', $customer->id)
            ->update([
                'shopify_order_id' => $shopifyOrderId,
                'shopify_order_no' => $shopifyOrderNumber,
            ]);

        $name = explode(' ', $customer->name);
        info('Name is ', [$name]);
        $first_name = $name[0];
        $last_name = $name[1] ?? $name[0];

        $shippingAddress = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'address1' => $customer->address,
            'address2' => '',
            'phone' => $customer->phone,
            'province' => $customer->state,
            'country' => $customer->country,
            'zip' => $customer->zip,
            'city' => $customer->city,
        ];


        $shippingUpdateResponse = $this->shopifyService->updateOrderShippingAddress($shopifyOrderId, $shippingAddress);
        info('Final Response is', $shippingUpdateResponse);

        if (!$shippingUpdateResponse['success']) {
            // Handle shipping address update error
            return ['status' => 400, "errors" => $shippingUpdateResponse['errors']];
        }
        return ['status' => 200, 'message' => 'Order created and shipping address updated successfully.'];
    }

    public function shareReview()
    {
        $customerId = Session::get('customer_id');
        $stepValidate = validateStep(config('app.funnel_step.step_3'));
        if (!$stepValidate) {
            return redirect()->route('homepage');
        }
        $customer = $this->customerRepositoryInterface->getById($customerId);
        return view('public.share-review', compact('customer'));
    }
    private function getAmazonOrders($order_id)
    {
        $url = config('amazon.get_amazon_order_api') . "/{$order_id}";
        $token = config('amazon.amazon_token');

        // Make the HTTP request
        $response = Http::withToken($token)->get($url);
        info('response is ', [$response]);
        // Return the response status and body
        return [
            'status' => $response->status(),
            'orders' => json_decode($response->body())
        ];
    }
    public function retryOrder($customerId)
    {
        $customer = Customer::with('order')->find($customerId);
        if (!$customer || $customer->funnel_step !== config('app.funnel_step.step_4')) {
            return response()->json(['status' => 403, 'message' => 'This user is not validated for this action.']);
        }

        session(['order_id' => $customer->order->order_no]);

        $create_shopify_order = $this->createOrder($customer);
        info('Create Shopify Order', [$create_shopify_order]);

        if ($create_shopify_order['status'] === 400) {
            $errorMessage = $create_shopify_order['errors']['shipping_address'][0]
                ?? 'An error occurred with the shipping address.';
            info('Error message', [$errorMessage]);

            return response()->json(['status' => 400, 'message' => $errorMessage]);
        }

        if (config('gorgias.service')) {
            $gorgias_service = $this->gorgiasService->addTicketToGorgias();
            info('Gorgias Service', [$gorgias_service]);
        }

        $this->customerRepositoryInterface->update(
            ['funnel_step' => config('app.funnel_step.step_5')],
            $customerId
        );

        $update_data = $this->orderRepositoryInterface->update(
            ['delievered' => 1],
            $customer->order->id
        );
        info('Update data', [$update_data]);

        return response()->json(['status' => 200, 'message' => 'Order Retried for ' . $customer->name]);
    }
}
