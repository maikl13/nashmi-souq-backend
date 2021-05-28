<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use App\Traits\PaymentTrait;
use App\Traits\ExchangeCurrency;

class Order extends Model
{
    use PaymentTrait, ExchangeCurrency;
    
    const CREDIT_PAYMENT = 1;
    const ON_DELIVERY_PAYMENT = 2;
    const PAYPAL_PAYMENT = 3;
    const MADA_PAYMENT = 3;

    const STATUS_UNPAID = 0; // for orders with credit payments that hasn't been paid yet
    const STATUS_PROCESSING = 1; // new order
    const STATUS_DELIVERED = 2; // delivered

    public function newQuery()
    {
        if(request()->store)
            return parent::newQuery()->where('store_id', request()->store->id);
        return parent::newQuery();
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function country(){
        // The buyer's country at the moment of making the order
        return $this->belongsTo(Country::class);
    }
    public function state(){
        return $this->belongsTo(State::class);
    }
    public function packages(){
        return $this->hasMany(Package::class);
    }
    public function currency(){
        return $this->belongsTo(Currency::class);
    }


    public function get_payment_method(){
        switch ($this->payment_method) {
            case Self::CREDIT_PAYMENT: return 'بطاقة الائتمان'; break;
            case Self::ON_DELIVERY_PAYMENT: return 'الدفع عند الاستلام'; break;
            case Self::PAYPAL_PAYMENT: return 'باي بال'; break;
            case Self::MADA_PAYMENT: return 'مدى'; break;
        }
    }
    public function is_paid(){
        return in_array($this->payment_method, [
            Self::CREDIT_PAYMENT,
            Self::PAYPAL_PAYMENT,
            Self::MADA_PAYMENT
        ]) && $this->status != Self::STATUS_UNPAID && $this->transaction && $this->transaction->is_processed();
    }
    public function shipping_method(){
        if( App::getLocale() == 'ar' )
           return $this->shipping_method == Self::NORMAL_SHIPPING ? 'شحن عادي' : 'الاستلام من مقر الشركة';
        return $this->shipping_method == Self::NORMAL_SHIPPING ? 'Normal Shipping' : 'Hand by Hand';
    }
    public function status(){
        switch ($this->status) {
            case Self::STATUS_UNPAID : return App::getLocale() == 'ar' ? 'غير مدفوع' : 'unpaid'; break;
            case Self::STATUS_PROCESSING : return App::getLocale() == 'ar' ? 'قيد المعالجة' : 'processing'; break;
            case Self::STATUS_DELIVERED : return App::getLocale() == 'ar' ? 'تم التسليم' : 'Delivered'; break;
        }
    }
    public function is_unpaid(){
        return $this->status == Self::STATUS_UNPAID || !$this->transaction || !$this->transaction->is_pending();
    }
    public function is_processing(){
        return $this->status == Self::STATUS_PROCESSING;
    }
    public function is_delivered(){
        return $this->status == Self::STATUS_DELIVERED;
    }

    public function transaction(){
        return $this->belongsTo(Transaction::class);
    }


    public function price(){
        $price = 0;
        foreach($this->packages as $package) 
            if(!$package->is_cancelled() && !$package->is_rejected())
                $price += $package->price();
        return $price;
    }
    public function price_in($currency){
        return Self::exchange($this->price(), $this->currency->code, 'EGP');
    }
}
