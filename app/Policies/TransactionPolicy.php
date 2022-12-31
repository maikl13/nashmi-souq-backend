<?php

namespace App\Policies;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TransactionPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, Transaction $transaction)
    {
        return $user->is_superadmin() ? true : false;
    }

    public function delete(User $user, Transaction $transaction)
    {
        return $user->is_superadmin() ? true : false;
    }
}
