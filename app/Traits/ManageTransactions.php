<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Transaction;
use App\Models\Listing;
use App\Models\Order;

trait ManageTransactions {

    // (deposits + revenues) - (withdrawals + expenses)
    // revenues = earned + reserved
    // current balance = (payout_balance + reserved_balance)

    public function transactions(){
        return $this->hasMany(Transaction::class);
    }

    
    public function current_balance(){
        // payout_balance + reserved_balance

        $current_balance = $this->payout_balance();
        $current_balance += $this->reserved_balance();

        return $current_balance;
    }

    public function payout_balance(){
        // (deposits + earned_revenues) - (withdrawals + expenses)

        // deposits
        $payout_balance = $this->transactions()->where('type', Transaction::TYPE_DEPOSIT)->where('status', Transaction::STATUS_PROCESSED)->sum('amount');

        // earned revenues
        $payout_balance = $this->store_earned_revenues();

        // withdrawal
        $payout_balance -= $this->transactions()->where('type', Transaction::TYPE_WITHDRAWAL)->where('status', Transaction::STATUS_PROCESSED)->sum('amount');

        // expenses
        $payout_balance -= $this->expensed_balance();
        

        return $payout_balance;
    }


    public function reserved_balance(){
        // the price of store orders that has'nt been delivered yet

        $reserved_balance = $this->store_pending_revenues();
        
        return $reserved_balance;
    }


    public function expensed_balance(){
        $expensed_balance = 0;
        foreach($this->featured_listings()->get() as $featured_listing){
            $expensed_balance += $featured_listing->price;
        }
        return $expensed_balance;
    }

}