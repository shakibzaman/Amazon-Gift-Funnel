<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        session()->forget(['customer_id', 'funnel_step', 'order_id', 'too_soon_flag', 'review', 'recommendation']);
        return view('public.index');
    }

    public function clearSession()
    {
        session()->flush();
        return response()->json(['message' => 'Session cleared']);
    }
}
