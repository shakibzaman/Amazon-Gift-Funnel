<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'funnel_name', 'product_asin', 'address', 'city', 'state', 'zip', 'country', 'funnel_step'];

    public function order()
    {
        return $this->belongsTo(CustomerOrder::class, 'id', 'customer_id');
    }
    public function review()
    {
        return $this->belongsTo(Review::class, 'id', 'customer_id');
    }
}
