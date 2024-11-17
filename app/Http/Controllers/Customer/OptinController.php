<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Mail\OptinMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class OptinController extends Controller
{
    public function optin(Request $request)
    {
        $options = session('options', []);
        return view('public.optin', compact('options'));
    }
    public function homepage_redirection($title)
    {
        if ($title == 'tv') {
            $options = ['QVC', 'Good Morning America', 'CBC'];
        } elseif ($title == 'pharmacies') {
            $options = ['CVS', 'Walgreens', 'Local Pharmacies'];
        } else {
            $options = [];
        }
        session(['options' => $options]);
        return redirect()->route('optin');
    }
    public function storeUserAction(Request $request)
    {
        $userInfo = $request->only(['user_name', 'user_email', 'user_phone', 'user_address', 'product_date_of_purchased', 'product_purchased_from', 'purchased_product']);
        Mail::to(config('app.optin_email_address'))->queue(new OptinMail($userInfo));
        session()->flash('message', 'Request sent successfully! Someone from our customer team has received your message and will contact you soon. Thank you!');
        return redirect()->back();
    }
}
