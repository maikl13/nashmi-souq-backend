<?php

namespace App\Models;

use App;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;

class OrderStatusUpdate extends Model
{
    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function status(){
        switch ($this->status) {
            case Order::STATUS_PENDING : return App::getLocale() == 'ar' ? 'قيد المراجعة' : 'pending'; break;
            case Order::STATUS_APPROVED : return App::getLocale() == 'ar' ? 'مقبول' : 'Approved'; break;
            case Order::STATUS_SOFT_REJECTED : return App::getLocale() == 'ar' ? 'مرفوض' : 'Soft Rejected'; break;
            case Order::STATUS_HARD_REJECTED : return App::getLocale() == 'ar' ? 'مرفوض نهائيا' : 'Rejected'; break;
            case Order::STATUS_DELIVERABLE : return App::getLocale() == 'ar' ? 'مرحلة التجهيز' : 'Under Preparation'; break;
            case Order::STATUS_PREPARED : return App::getLocale() == 'ar' ? 'مرحلة التسليم' : 'Out For Delivery'; break;
            case Order::STATUS_CANCELLED : return App::getLocale() == 'ar' ? 'ملغي' : 'Cancelled'; break;
            case Order::STATUS_DELIVERED : return App::getLocale() == 'ar' ? 'تم التسليم' : 'Delivered'; break;
        }
    }
}
