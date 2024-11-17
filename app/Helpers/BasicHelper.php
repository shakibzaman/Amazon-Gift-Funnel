<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;



function validateStep($step = null)
{
    info('Get funnel', [Session::get('funnel_step')]);
    info("request", [$step]);
    if (Session::get('funnel_step') == $step) {
        logger('True is t');
    } else {
        logger('False is t');
    }
    $step = $step ?? config('app.funnel_step.step_1');
    if (Session::has('customer_id') && Session::get('funnel_step') === $step) {
        info('All true');
        return true;
    }
    return false;
}
