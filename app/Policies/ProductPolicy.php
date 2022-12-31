<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Product $product)
    {
        return $product->user_id === $user->id;
    }

    public function delete(User $user, Product $product)
    {
        return $product->user_id === $user->id;
    }
}
