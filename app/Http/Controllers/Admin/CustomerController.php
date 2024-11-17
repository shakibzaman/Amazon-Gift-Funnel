<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Review;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerRepository;

    public function __construct(CustomerRepositoryInterface $customerRepository)
    {
        $this->customerRepository = $customerRepository;
    }

    public function customerList(Request $request)
    {
        $customers = $this->customerRepository->index($request);
        return view('admin.customers', compact('customers'));
    }
    public function exportCSV()
    {
        $customers = $this->customerRepository->getAllCustomers();
        $filename = "customers.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['Contacted', 'Name', 'Email', 'Phone', 'Order ID', 'ASIN Purchased', '2nd Gift', 'Date', 'Rating', 'Last Step', 'Funnel Name', 'Note']);

        foreach ($customers as $customer) {
            fputcsv($handle, [
                $customer->contacted == 1 ? 'Yes' : 'No',
                $customer->name,
                $customer->email,
                $customer->phone,
                $customer->order->order_no ?? '',
                $customer->product_asin,
                $customer->order ? ($customer->order->second_order == 0 ? 'Not Requested' : ($customer->order->order_type == 1 ? 'Requested Oximeter' : 'Requested Thermometer')) : 'N/A',
                $customer->created_at,
                $customer->review->recommendation ?? 0,
                $customer->funnel_step,
                $customer->funnel_name,
                $customer->note
            ]);
        }

        fclose($handle);

        $headers = [
            'Content-Type' => 'text/csv',
        ];

        return response()->download($filename, $filename, $headers);
    }
    public function getCustomerReview($review_id)
    {
        $customerReview = Review::where('id', $review_id)->first();
        $review = $customerReview->review;
        return view('admin.modal.viewReview', compact('review'));
    }
    public function getCustomerNote($customerId)
    {
        $customer = $this->customerRepository->getById($customerId);
        return view('admin.modal.update-note', compact('customer'));
    }
    public function updateCustomerNote(Request $request)
    {
        $this->customerRepository->update(['note' => $request->note], $request->customerId);
        return redirect()->back();
    }
    public function updateCustomerContact(Request $request)
    {
        $customer = $this->customerRepository->update(['contacted' => $request->contact], $request->customerId);

        if ($customer) {
            return ['status' => 200, 'Contacted Data Updated'];
        } else {
            return ['status' => 400, 'Error ! Contacted Data Not Updated'];
        }
    }
}
