<?php

namespace App\Http\Controllers\Customer;

use App\Classes\WebResponseClass;
use App\Http\Controllers\Controller;
use App\Http\Requests\CustomerStoreRequest;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerRepositoryInterface;
use App\Services\ZapierService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\DB;

class CustomerController extends Controller
{
    private CustomerRepositoryInterface $customerRepositoryInterface;
    protected $zapierService;
  

    public function __construct(CustomerRepositoryInterface $customerRepositoryInterface, ZapierService $zapierService)
    {
        $this->customerRepositoryInterface = $customerRepositoryInterface;
        $this->zapierService = $zapierService;
    }

    public function store(CustomerStoreRequest $request)
    {

        $details = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'funnel_name' => config('app.funnel_name')
        ];
        DB::beginTransaction();
        try {
            // Store Customer details 
            $customer = $this->customerRepositoryInterface->store($details);
            DB::commit();

            // Store Customer details in session

            session(['customer_id' => $customer->id]);
            session(['funnel_step' => config('app.funnel_step.step_1')]);

            $response = $this->zapierService->sendData($details);
            info('Zapier Response', [$response]);
            return redirect()->route('customer.check.order.page');
        } catch (\Exception $ex) {
            info('Error store customer', [$ex->getMessage()]);
            return WebResponseClass::rollback($ex);
        }
    }
    private function _zapierPost($request)
    {
        $response = Http::post('https://hooks.zapier.com/hooks/catch/129991/2yn7r84/', [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone
        ]);
        info('Response for zapier', [$response]);
    }
}
