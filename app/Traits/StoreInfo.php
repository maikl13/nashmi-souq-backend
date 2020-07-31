<?php

namespace App\Traits;

use App\Models\Order;
use Illuminate\Http\Request;

trait StoreInfo {

    public function is_store()
    {
        return $this->store_name ? true : false;
    }

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

    public function has_payout_method()
    {
        return $this->paypal || $this->national_id || $this->vodafone_cash;
    }
}