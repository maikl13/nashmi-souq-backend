<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App;
use App\Models\Order;

class Package extends Model
{
    const STATUS_PENDING = 1; // new order
        const STATUS_APPROVED = 2; // approved and set shipping fees
        const STATUS_SOFT_REJECTED = 3; // rejected for reason
        const STATUS_HARD_REJECTED = 4; // rejected for reason
    const STATUS_DELIVERABLE = 5; // under preparation
        const STATUS_PREPARED = 6 ; // Out For Delivery
        const STATUS_CANCELLED = 7 ; // Cancelled
    const STATUS_DELIVERED = 8; // delivered

    public function order(){
        return $this->belongsTo(Order::class);
    }
    public function package_items(){
        return $this->hasMany(PackageItem::class);
    }
    public function package_status_updates(){
        return $this->hasMany(PackageStatusUpdate::class);
    }
    public function store(){
        return $this->belongsTo(User::class,'store_id');
    }

    public function status(){
        if($this->is_unpaid()) return App::getLocale() == 'ar' ? 'غير مدفوع' : 'unpaid';
        switch ($this->status) {
            case Self::STATUS_PENDING : return App::getLocale() == 'ar' ? 'قيد المراجعة' : 'pending'; break;
            case Self::STATUS_APPROVED : return App::getLocale() == 'ar' ? 'مقبول' : 'Approved'; break;
            case Self::STATUS_SOFT_REJECTED : return App::getLocale() == 'ar' ? 'مرفوض' : 'Rejected'; break;
            case Self::STATUS_HARD_REJECTED : return App::getLocale() == 'ar' ? 'مرفوض' : 'Rejected'; break;
            case Self::STATUS_DELIVERABLE : return App::getLocale() == 'ar' ? 'مرحلة التجهيز' : 'Under Preparation'; break;
            case Self::STATUS_PREPARED : return App::getLocale() == 'ar' ? 'مرحلة التسليم' : 'Out For Delivery'; break;
            case Self::STATUS_CANCELLED : 
                if ($this->is_cancelled_by_buyer())
                    return App::getLocale() == 'ar' ? 'ملغي من قبل المشتري' : 'Cancelled'; 
                return App::getLocale() == 'ar' ? 'ملغي' : 'Cancelled'; 
                break;
            case Self::STATUS_DELIVERED : return App::getLocale() == 'ar' ? 'تم التسليم' : 'Delivered'; break;
        }
    }
    
    public function is_unpaid(){
        return $this->order->status == Order::STATUS_UNPAID;
    }
    public function is_pending(){
        return $this->status == Self::STATUS_PENDING;
    }
    public function is_approved(){
        return $this->status == Self::STATUS_APPROVED;
    }
    public function is_rejected(){
        return $this->status == Self::STATUS_SOFT_REJECTED || $this->status == Self::STATUS_HARD_REJECTED;
    }
    public function is_soft_rejected(){
        return $this->status == Self::STATUS_SOFT_REJECTED;
    }
    public function is_hard_rejected(){
        return $this->status == Self::STATUS_HARD_REJECTED;
    }
    public function is_deliverable(){
        return $this->status == Self::STATUS_DELIVERABLE;
    }
    public function is_prepared(){
        return $this->status == Self::STATUS_PREPARED;
    }
    public function is_cancelled(){
        return $this->status == Self::STATUS_CANCELLED;
    }
    public function is_cancelled_by_buyer(){
        $package_latest_status = $this->package_status_updates()->latest()->first();
        return $this->is_cancelled() && $package_latest_status && $package_latest_status->user_id == $this->user_id ? true : false;
    }
    public function is_delivered(){
        return $this->status == Self::STATUS_DELIVERED;
    }

    public function seller_note()
    {
        $last_status_update = $this->package_status_updates()->latest()->first();
        return $last_status_update && $last_status_update->note ? $last_status_update->note : null;
    }
    public function price(){
        $price = 0;
        foreach($this->package_items as $item) $price += $item->total_price();
        return $price;
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::creating(function(Package $package) {
            $package->price_usd = $package->order->currency->code == 'USD' ? $package->price() : Self::exchange($package->price(), $package->order->currency->code, 'USD');
        });
    }
}
