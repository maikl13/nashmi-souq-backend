<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Order $order)
    {
        return $user->id === $order->user_id;
    }

    public function cancel(User $user, Order $order)
    {
        if( $order->is_pending() || $order->is_approved() )
            return $user->id === $order->user_id;
        return false;
    }

    public function confirm(User $user, Order $order)
    {
        if( $order->is_approved() )
            return $user->id === $order->user_id;
        return false;
    }

    public function show_for_buyer(User $user, Order $order)
    {
        return $user->id === $order->store_id;
    }

    public function change_status(User $user, Order $order)
    {
        if($order->is_cancelled_by_buyer()) return $user->id === $order->user_id;
        return $user->id === $order->store_id;
    }
}
