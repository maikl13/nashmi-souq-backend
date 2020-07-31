<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Package;
use Illuminate\Auth\Access\HandlesAuthorization;

class PackagePolicy
{
    use HandlesAuthorization;

    public function cancel(User $user, Package $package)
    {
        if( $package->is_pending() )
            return $user->id === $package->order->user_id;
        return false;
    }

    public function show_for_store(User $user, Package $package)
    {
        return $user->id === $package->store_id;
    }

    public function change_status(User $user, Package $package)
    {
        if($package->is_cancelled_by_buyer()) return $user->id === $package->user_id;
        return $user->id === $package->store_id;
    }
}
