<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Http\Request;

trait StoreInfo {

    public function store_name()
    {
        return $this->store_name ? $this->store_name : $this->name;
    }

    public function store_image()
    {
        if($this->store_logo) return $this->store_logo();
        if($this->profile_picture) return $this->profile_picture();
        return $this->store_name ? $this->store_logo() : $this->profile_picture();
    }

    public function store_revenues()
    {
        // Total store revenues in local currency
        $revenues = 0;
        foreach($this->store_orders()->get() as $order){
            $revenues += $order->total_local_price();
        }
        return $revenues;
    }

    public function store_earned_revenues()
    {
        // Total store revenues in local currency for delevered orders
        $revenues = 0;
        foreach($this->store_orders()->where('status', Order::STATUS_DELIVERED)->get() as $order){
            $revenues += $order->total_local_price();
        }
        return $revenues;
    }

    public function store_pending_revenues()
    {
        // Total store revenues in local currency for non delivered orders
        $revenues = 0;
        foreach($this->store_orders()->where('status', '!=', Order::STATUS_DELIVERED)->get() as $order){
            $revenues += $order->total_local_price();
        }
        return $revenues;
    }
}