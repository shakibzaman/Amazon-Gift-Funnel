<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

interface CustomerRepositoryInterface
{

    public function getById($id);
    public function getByEmail($email);
    public function store(array $data);
    public function update(array $data, $id);
    public function updateByEmail(array $data, $email);
    public function index(Request $request): LengthAwarePaginator;
    public function getAllCustomers(): Collection;
}
