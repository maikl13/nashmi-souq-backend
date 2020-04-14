<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Listing;

trait ManageTransactions {

    // total_balance = (current_balance + expensed_balance)
    // current balance = (payout_balance + reserved_balance)

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }


    public function total_balance(){
        // deposits - withdrawals

        // deposits
        $total_balance = $this->transactions()->where('type', Transaction::TYPE_DEPOSIT)->where('status', Transaction::STATUS_PROCESSED)->sum('amount');

        // withdrawal
        $total_balance -= $this->transactions()->where('type', Transaction::TYPE_WITHDRAWAL)->where('status', Transaction::STATUS_PROCESSED)->sum('amount');

        return $total_balance;
    }


    public function current_balance(){
        // total_balance - expenses

        // total_balance
        $current_balance = $this->total_balance();

        // expenses
        foreach($this->featured_listings()->get() as $featured_listing){
            $current_balance -= $featured_listing->price;
        }

        return $current_balance;
    }

    public function expensed_balance(){
        return $this->total_balance() - $this->current_balance();
    }

}