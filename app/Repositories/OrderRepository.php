<?php

namespace App\Repositories;

use App\Interfaces\OrderRepositoryInterface;
use App\Models\CustomerOrder;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function checkingOrder(array $data)
    {
        return CustomerOrder::create($data);
    }
    public function orderSurveyAction(array $data)
    {
    }
    public function update(array $data, $id)
    {
        return CustomerOrder::whereId($id)->update($data);
    }
}
