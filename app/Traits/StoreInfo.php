<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\Promotion;
use Illuminate\Http\Request;

trait StoreInfo {

    public function promotions()
    {
        return $this->hasMany(Promotion::class);
    }

    public function is_store()
    {
        return $this->store_name && $this->store_slug ? true : false;
    }

    public function is_active_store()
    {
        if(!$this->is_store()) return false;
        $subscription = $this->subscriptions()->active()->where('start', '<=', now())->where('end', '>=', now()->subDays(setting('grace_period')))->first();
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
        if(!$subscription && setting('trial_period'))
            $subscription = $this->subscriptions()->create([
                'start' => now(),
                'end' => now()->addDays(setting('trial_period')),
                'type' => Subscription::TYPE_TRIAL,
                'status' => Subscription::STATUS_ACTIVE,
            ]);
        return $subscription;
    }

    public function store_url()
    {
        $protocol = env('APP_PROTOCOL') ?? 'http';
        if($this->is_store())
            return $protocol.'://'.$this->store_slug.'.'.str_replace('http://', '', str_replace('https://', '', config('app.url')));
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

    public function is_about_to_end()
    {
        $subscription = $this->subscriptions()->active()->orderBy('end', 'desc')->first();
        return $subscription->end >= now() && $subscription->end < now()->addDays(3) ? true : false;
    }

    public function in_grace_period()
    {
        $subscription = $this->subscriptions()->active()->orderBy('end', 'desc')->first();
        return $subscription->end < now() && $subscription->end >= now()->subDays(setting('grace_period')) ? true : false;
    }

    public function remaining_days()
    {
        $subscription = $this->subscriptions()->active()->orderBy('end', 'desc')->first();
        return optional($subscription->end)->isFuture() ? $subscription->end->diffInDays() : 0;
    }
}