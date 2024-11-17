<?php

namespace App\Repositories;

use App\Interfaces\ReviewRepositoryInterface;
use App\Models\Review;

class ReviewRepository implements ReviewRepositoryInterface
{
    /**
     * Create a new class instance.
     */
    public function store(array $data)
    {
        return Review::create($data);
    }
}
