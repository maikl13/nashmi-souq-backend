<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\ExchangeCurrency;
use App\Models\SubTransaction;
use App\Traits\PaymentTrait;

class Transaction extends Model
{
    use PaymentTrait, ExchangeCurrency;

    const TYPE_DEPOSIT = 1;
    const TYPE_WITHDRAWAL = 2;
    const TYPE_PAYMENT = 3; // direct payment via credit card, can be treated as expensed deposit
    const TYPE_EXPENSE = 4; // expenses from the wallet

    const STATUS_PENDING = 0;
    const STATUS_PROCESSED = 1;
    const STATUS_CANCELLED = 2;

    const PAYMENT_DIRECT_PAYMENT = 1;
    const PAYMENT_BANK_DEPOSIT = 2;
    const PAYMENT_FAWRY = 3;
    const PAYMENT_VODAFONE_CASH = 4;
    const PAYMENT_POSTAL_OFFICE = 5;
    const PAYMENT_PAYPAL = 6;
    const PAYMENT_WALLET = 7;
    const PAYMENT_OTHER = 6;

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function currency(){
        return $this->belongsTo(Currency::class);
    }
    public function sub_transactions()
    {
        return $this->hasMany(SubTransaction::class);
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
    
    public function is_expense(){
        return $this->type == $this::TYPE_EXPENSE;
    }

    public function type(){
        switch ($this->type) {
            case $this::TYPE_DEPOSIT: return 'إيداع'; break;
            case $this::TYPE_WITHDRAWAL: return 'سحب'; break;
            case $this::TYPE_PAYMENT: return 'دفع مباشر'; break;
            case $this::TYPE_EXPENSE: return 'مصروفات'; break;
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
            case $this::STATUS_CANCELLED: return 'ملغية'; break;
        }
    }

    public function amount()
    {
        if($this->currency->id != currency()->id)
            return Self::exchange($this->amount, $this->currency->code, currency()->code);
        return $this->amount;
    }

    public function payment_method(){
        switch ($this->payment_method) {
            case $this::PAYMENT_DIRECT_PAYMENT: return 'دفع مباشر'; break;
            case $this::PAYMENT_BANK_DEPOSIT: return 'إيداع بنكي'; break;
            case $this::PAYMENT_FAWRY: return 'فوري'; break;
            case $this::PAYMENT_VODAFONE_CASH: return 'فودافون كاش'; break;
            case $this::PAYMENT_POSTAL_OFFICE: return 'حوالة البريد المصري'; break;
            case $this::PAYMENT_PAYPAL: return 'باي بال'; break;
            case $this::PAYMENT_WALLET: return 'خصم من المحفظة'; break;
            case $this::PAYMENT_OTHER: return 'أخرى'; break;
        }
    }

    // this is a recommended way to declare event handlers
    protected static function boot() {
        parent::boot();

        static::saving(function(Transaction $transaction) {
            $transaction->amount_usd = Self::exchange($transaction->amount, $transaction->currency->code, 'USD');
        });
        
        static::saved(function(Transaction $transaction) {
            if($transaction->is_withdrawal() || $transaction->is_expense()){
                $amount = $transaction->amount;

                foreach($transaction->sub_transactions as $sub_transaction)
                    $sub_transaction->delete();
                
                $payout_balance = $transaction->user->payout_balance(true);

                // Move current currency to top
                $current_currency[$transaction->currency->code] = $payout_balance[$transaction->currency->code];
                unset($payout_balance[$transaction->currency->code]);
                $payout_balance = $current_currency+$payout_balance;

                foreach($payout_balance as $currency => $balance){
                    if($amount > 0){
                        $exchanged_amount = Self::exchange($amount, $transaction->currency->code, $currency);

                        $sub_transaction = new SubTransaction;
                        $sub_transaction->transaction_id = $transaction->id;
                        $sub_transaction->original_amount = $balance >= $exchanged_amount ? $exchanged_amount : $balance;
                        $sub_transaction->original_currency_id = Currency::where('code', $currency)->first()->id;
                        $sub_transaction->currency_id = $transaction->currency->id;
                        $sub_transaction->amount = $sub_transaction->original_amount == $exchanged_amount ? $amount : Self::exchange($sub_transaction->original_amount, $currency , $transaction->currency->code);
                        $amount -= $sub_transaction->amount;
                        $sub_transaction->save();
                    } else { break; }
                    unset($payout_balance[$currency]); 
                }
            }
        });
    }
}
