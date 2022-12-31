<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;

class PackageStatusUpdate extends Model
{
    public function package()
    {
        return $this->belongsTo(Package::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function status()
    {
        switch ($this->status) {
            case Package::STATUS_PENDING: return App::getLocale() == 'ar' ? 'قيد المراجعة' : 'pending';
            break;
            case Package::STATUS_APPROVED: return App::getLocale() == 'ar' ? 'مقبول' : 'Approved';
            break;
            case Package::STATUS_SOFT_REJECTED: return App::getLocale() == 'ar' ? 'مرفوض' : 'Soft Rejected';
            break;
            case Package::STATUS_HARD_REJECTED: return App::getLocale() == 'ar' ? 'مرفوض نهائيا' : 'Rejected';
            break;
            case Package::STATUS_DELIVERABLE: return App::getLocale() == 'ar' ? 'مرحلة التجهيز' : 'Under Preparation';
            break;
            case Package::STATUS_PREPARED: return App::getLocale() == 'ar' ? 'مرحلة التسليم' : 'Out For Delivery';
            break;
            case Package::STATUS_CANCELLED: return App::getLocale() == 'ar' ? 'ملغي' : 'Cancelled';
            break;
            case Package::STATUS_DELIVERED: return App::getLocale() == 'ar' ? 'تم التسليم' : 'Delivered';
            break;
        }
    }
}
