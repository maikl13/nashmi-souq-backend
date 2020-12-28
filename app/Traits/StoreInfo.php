<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\Subscription;
use Illuminate\Http\Request;

trait StoreInfo {

    public function is_store()
    {
        return $this->store_name && $this->store_slug ? true : false;
    }

    public function is_active_store()
    {
        $subscription = $this->subscriptions()->where('start', '<=', now())->where('end', '>=', now())->first();
        return $subscription ? true : false;
    }

    public function is_subscriped()
    {
        return true;
    }

    public function started_trial()
    {
        return $this->trial_started_at ? true : false;
    }

    public function start_trial()
    {
        $subscription = $this->subscriptions()->first();
        if(!$subscription)
            $subscription = $this->subscriptions()->create([
                'start' => now(),
                'end' => now()->addDays(14),
                'type' => Subscription::TYPE_TRIAL,
            ]);
        return $subscription;
    }

    public function store_url()
    {
        if($this->is_store())
            return 'http://'.$this->store_slug.'.'.str_replace('http://', '', str_replace('https://', '', config('app.url')));
        return config('app.url');
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
        return $this->bank_account || $this->paypal || $this->national_id || $this->vodafone_cash;
    }
}