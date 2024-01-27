<?php

namespace App\Traits;

use App\Models\Order;
use App\Models\Listing;
use App\Models\Package;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Support\Facades\Cache;

trait ManageTransactions
{
    // (deposits + revenues) - (withdrawals + expenses)
    // revenues = earned + reserved
    // current balance = (payout_balance + reserved_balance)

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function payout_balance($detailed = false)
    {
        // (deposits + earned_revenues) - (withdrawals + expenses)
        $payout_balance = [];

        $currencies = Cache::remember('currencies', 60 * 60, function () {
            return Currency::get();
        });

        foreach ($currencies as $currency) {
            $payout_balance[$currency->code] = 0;
        }

        // deposits
        $deposit_transactions = $this->transactions()->where('type', Transaction::TYPE_DEPOSIT)->processed()->get();
        foreach ($deposit_transactions as $transaction) {
            $payout_balance[$transaction->currency->code] += $transaction->amount;
        }

        // deposits => Payments Can be treated as deposit too since it's a deposit that is expensed immediately
        $payment_transactions = $this->transactions()->where('type', Transaction::TYPE_PAYMENT)->processed()->get();
        foreach ($payment_transactions as $transaction) {
            $payout_balance[$transaction->currency->code] += $transaction->amount;
        }

        // earned revenues
        // Total store revenues in local currency for delevered packages
        foreach ($this->store_packages()->where('status', Package::STATUS_DELIVERED)->get() as $package) {
            if ($package->order->payment_method == Order::CREDIT_PAYMENT) {
                foreach ($package->package_items as $item) {
                    $payout_balance[$item->original_currency->code] += $item->original_price();
                }
            }
        }

        // withdrawal
        $withdrawal_transactions = $this->transactions()->where('type', Transaction::TYPE_WITHDRAWAL)->get();
        foreach ($withdrawal_transactions as $transaction) {
            foreach ($transaction->sub_transactions as $sub_transaction) {
                $payout_balance[$sub_transaction->original_currency->code] -= $sub_transaction->original_amount;
            }
        }

        // expenses
        foreach ($this->expensed_balance(true) as $currency => $expensed) {
            $payout_balance[$currency] -= $expensed;
        }

        return $detailed ? $this->detailed_balance($payout_balance) : $this->local_balance($payout_balance);
    }

    public function reserved_balance($detailed = false)
    {
        // the price of store orders that has'nt been delivered yet
        $reserved_balance = [];
        foreach (Currency::get() as $currency) {
            $reserved_balance[$currency->code] = 0;
        }

        // Total store revenues in local currency for non delivered packages
        foreach ($this->store_packages()->where('status', '!=', Package::STATUS_DELIVERED)->with('order.transaction', 'package_items')->get() as $package) {
            if (! $package->is_rejected() && ! $package->is_cancelled()) {
                $order = $package->order;
                if ($order->payment_method != Order::ON_DELIVERY_PAYMENT && $order->status != Order::STATUS_UNPAID && $order->transaction && $order->transaction->is_processed()) {
                    foreach ($package->package_items as $item) {
                        $reserved_balance[$item->original_currency->code] += $item->original_price();
                    }
                }
            }
        }

        return $detailed ? $this->detailed_balance($reserved_balance) : $this->local_balance($reserved_balance);
    }

    public function expensed_balance($detailed = false)
    {
        $expensed_balance = [];
        foreach (Currency::get() as $currency) {
            $expensed_balance[$currency->code] = 0;
        }

        // foreach($this->featured_listings()->get() as $featured_listing)
        //     $expensed_balance[$featured_listing->currency->code] += $featured_listing->price;
        $expenses_transactions = $this->transactions()->with('sub_transactions', 'sub_transactions.original_currency')->where('type', Transaction::TYPE_EXPENSE)->get();
        foreach ($expenses_transactions as $transaction) {
            foreach ($transaction->sub_transactions as $sub_transaction) {
                $expensed_balance[$sub_transaction->original_currency->code] += $sub_transaction->original_amount;
            }
        }

        foreach ($this->orders()->where('payment_method', Order::CREDIT_PAYMENT)
            ->where('status', '!=', Order::STATUS_UNPAID)
            ->with('transaction', 'packages')->get() as $order) {
            if ($order->transaction && $order->transaction->is_processed()) {
                foreach ($order->packages as $package) {
                    if (! $package->is_rejected() && ! $package->is_cancelled()) {
                        $expensed_balance[$order->currency->code] += $package->price();
                    }
                }
            }
        }

        foreach ($this->subscriptions()->active()->with('transaction', 'transaction.currency')->get() as $supscription) {
            if ($transaction = $supscription->transaction) {
                $expensed_balance[$transaction->currency->code] += $transaction->amount;
            }
        }

        return $detailed ? $this->detailed_balance($expensed_balance) : $this->local_balance($expensed_balance);
    }

    public function local_balance(array $balance)
    {
        $local_balance = 0;
        foreach ($balance as $currency => $amount) {
            $local_balance += $currency == currency()->code ? $amount : self::exchange($amount, $currency, currency()->code, true);
        }

        return $local_balance;
    }

    public function detailed_balance(array $balance)
    {
        foreach ($balance as $currency => $amount) {
            $balance[$currency] = round($amount, 4) + 0;
        }

        return $balance;
    }
}
