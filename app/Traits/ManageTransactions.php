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
        $total_balance = $this->transactions()->where('type', Transaction::TYPE_DEPOSIT)->sum('amount');

        // withdrawal
        $total_balance -= $this->transactions()->where('type', Transaction::TYPE_WITHDRAWAL)->sum('amount');

        return $total_balance;
    }


    public function current_balance(){
        // deposits - (withdrawals + expenses)

        // deposits
        $current_balance = $this->transactions()->where('type', Transaction::TYPE_DEPOSIT)->sum('amount');

        // withdrawal
        $current_balance -= $this->transactions()->where('type', Transaction::TYPE_WITHDRAWAL)->sum('amount');

        // expenses
        // foreach($this->jobs()->where('status', Job::STATUS_CLOSED)->get() as $job){
        //     $current_balance -= $job->hiring_commission;
        //     if($job->is_managed())
        //         $current_balance -= $job->management_fees();
        // }

        return $current_balance;
    }


    public function reserved_balance(){
        // for employer = hiring_commission_for_open_jobs
        // for referrer = revenues_in_the_last_month

        $reserved_balance = 0;

        // hiring_commission_for_open_jobs + management fees
        if($this->is_employer()){
            foreach($this->jobs()->where('status', Job::STATUS_OPEN)->whereDate('created_at', '>', Carbon::now()->subDays( Job::EXPIRES_IN ))->get() as $job){
                $reserved_balance += $job->hiring_commission;
                if($job->is_managed())
                    $reserved_balance += $job->management_fees();
            }
        }

        // revenues_in_the_last_month
        if($this->is_referrer()){
            foreach($this->candidates()->where('status', Candidate::STATUS_ACCEPTED)->get() as $candidate){
                if(
                    $candidate->job->job_status_updates()
                        ->where('status', Job::STATUS_CLOSED)
                        ->latest()->first()->created_at > Carbon::now()->subMinutes( Job::REFERAL_BONUS_RESERVED_FOR )
                ){
                    $reserved_balance += $candidate->job->hiring_commission * Job::REFERAL_BONUS/100;
                }
            }
        }
        return $reserved_balance;
    }


    public function payout_balance(){
        // current_balance - reserved_balance
        return $this->current_balance() - $this->reserved_balance();
    }


    public function expensed_balance(){
        return $this->total_balance() - $this->current_balance();
    }

}