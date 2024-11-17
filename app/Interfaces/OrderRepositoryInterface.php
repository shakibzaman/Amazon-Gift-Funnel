<?php

namespace App\Interfaces;

interface OrderRepositoryInterface
{
    public function checkingOrder(array $data);
    public function orderSurveyAction(array $data);
    public function update(array $data, $id);
}
