<?php

namespace App\Repositories;

use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class CustomerRepository implements CustomerRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function index(Request $request): LengthAwarePaginator
    {
        $query = Customer::with('order', 'review')->orderBy('created_at', 'desc');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('email', 'like', "%$search%");
            });
        }

        return $query->paginate(10);
    }
    public function getAllCustomers(): Collection
    {
        return Customer::with('order', 'review')->orderBy('created_at', 'desc')->get();
    }
    public function store(array $data)
    {
        return Customer::create($data);
    }
    public function update(array $data, $id) 
    {
        return Customer::whereId($id)->update($data);
    }
    public function updateByEmail(array $data, $email)
    {
        return Customer::where('email', $email)->update($data);
    }
    public function getById($id)
    {
        return Customer::findOrFail($id);
    }
    public function getByEmail($email)
    {
        return Customer::where('email', $email)->firstOrFail();
    }
}
