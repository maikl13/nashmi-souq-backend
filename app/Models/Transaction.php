<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    const TYPE_DEPOSIT = 1;
    const TYPE_WITHDRAWAL = 2;
    const TYPE_PAYMENT = 3;

    const STATUS_PENDING = 0;
    const STATUS_PROCESSED = 1;

    const PAYMENT_DIRECT_PAYMENT = 1;
    const PAYMENT_BANK_DEPOSIT = 2;
    const PAYMENT_FAWRY = 3;
    const PAYMENT_VODAFONE_CASH = 4;
    const PAYMENT_OTHER = 5;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function is_deposit(){
        return $this->type == $this::TYPE_DEPOSIT;
    }

    public function is_withdrawal(){
        return $this->type == $this::TYPE_WITHDRAWAL;
    }

    public function is_payment(){
        return $this->type == $this::TYPE_PAYMENT;
    }

    public function type(){
        switch ($this->type) {
            case $this::TYPE_DEPOSIT: return 'إيداع'; break;
            case $this::TYPE_WITHDRAWAL: return 'سحب'; break;
            case $this::TYPE_PAYMENT: return 'دفع'; break;
        }
    }

    public function is_pending()
    {
        return $this->status == $this::STATUS_PENDING;
    }

    public function is_processed()
    {
        return $this->status == $this::STATUS_PROCESSED;
    }

    public function status(){
        switch ($this->status) {
            case $this::STATUS_PENDING: return 'قيد المراجعة'; break;
            case $this::STATUS_PROCESSED: return 'مكتملة'; break;
        }
    }

    public function payment_method(){
        switch ($this->payment_method) {
            case $this::PAYMENT_DIRECT_PAYMENT: return 'دفع مباشر'; break;
            case $this::PAYMENT_BANK_DEPOSIT: return 'إيداع بنكي'; break;
            case $this::PAYMENT_FAWRY: return 'فوري'; break;
            case $this::PAYMENT_VODAFONE_CASH: return 'فودافون كاش'; break;
            case $this::PAYMENT_OTHER: return 'أخرى'; break;
        }
    }
}
