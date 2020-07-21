<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    const NORMAL_SHIPPING = 1;
    const NO_SHIPPING = 2;

    const CREDIT_PAYMENT = 1;
    const ON_DELIVERY_PAYMENT = 2;

    const STATUS_PENDING = 1; // new order
        const STATUS_APPROVED = 2; // approved and set shipping fees
        const STATUS_SOFT_REJECTED = 3; // rejected for reason
        const STATUS_HARD_REJECTED = 4; // rejected for reason
    const STATUS_DELIVERABLE = 5; // under preparation
        const STATUS_PREPARED = 6 ; // Out For Delivery
        const STATUS_CANCELLED = 7 ; // Cancelled
    const STATUS_DELIVERED = 8; // delivered

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function store(){
        return $this->belongsTo(User::class,'store_id');
    }
    public function country(){
        // The buyer's country at the moment of making the order
        return $this->belongsTo(Country::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }
    public function order_status_updates(){
        return $this->hasMany(OrderStatusUpdate::class);
    }
    public function listing(){
        return $this->belongsTo(Listing::class);
    }


    public function payment_method(){
        if( App::getLocale() == 'ar' )
           return $this->payment_method == Self::CREDIT_PAYMENT ? 'بطاقة الائتمان' : 'الدفع عند الاستلام';
        return $this->payment_method == Self::CREDIT_PAYMENT ? 'Credit Card' : 'Payment On Delivery';
    }
    public function shipping_method(){
        if( App::getLocale() == 'ar' )
           return $this->shipping_method == Self::NORMAL_SHIPPING ? 'شحن عادي' : 'الاستلام من مقر الشركة';
        return $this->shipping_method == Self::NORMAL_SHIPPING ? 'Normal Shipping' : 'Hand by Hand';
    }
    public function status(){
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
        $order_latest_status = $this->order_status_updates()->latest()->first();
        return $this->is_cancelled() && $order_latest_status && $order_latest_status->user_id == $this->user_id ? true : false;
    }
    public function is_delivered(){
        return $this->status == Self::STATUS_DELIVERED;
    }



    public function price(){
        return $this->price+0;
    }
    public function local_price(){
        return $this->price+0;
    }
    public function total_price(){
        return $this->price() * $this->quantity;
    }
    public function total_local_price(){
        return $this->price() * $this->quantity;
    }

    public function admin_note()
    {
        $last_status_update = $this->order_status_updates()->latest()->first();
        return $last_status_update && $last_status_update->note ? $last_status_update->note : null;
    }
}
