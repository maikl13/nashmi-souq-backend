<?php

namespace App\Http\Controllers\Store;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\DataTables\SubscriptionsDataTable;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Models\Currency;

class SubscriptionController extends Controller
{
    public function index(SubscriptionsDataTable $dataTable)
    {
        return $dataTable->render('store-dashboard.subscriptions.subscriptions');
    }

    public function subscribe()
    {
        return view('main.store.subscribe');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subscription_type' => 'in:1,2,3',
            'payment_method' => 'in:'.Transaction::PAYMENT_DIRECT_PAYMENT.','.Transaction::PAYMENT_PAYPAL.','.Transaction::PAYMENT_MADA,
        ]);

        switch ($request->subscription_type) {
            case 2:
                $period = 183;
                $price = setting('half_year_subscription');
                $subscription_name = 'إشتراك نصف سنوي في المتاجر المدفوعة من سوق نشمي';
                $type = Subscription::TYPE_HALF_YEAR;
                break;
            case 3:
                $period = 365;
                $price = setting('yearly_subscription');
                $subscription_name = 'إشتراك سنوي في المتاجر المدفوعة من سوق نشمي';
                $type = Subscription::TYPE_YEARLY;
                break;
            default:
                $period = 30;
                $price = setting('monthly_subscription');
                $subscription_name = 'إشتراك شهري في المتاجر المدفوعة من سوق نشمي';
                $type = Subscription::TYPE_MONTHLY;
                break;
        }

        $last_subscription = auth()->user()->subscriptions()->active()->orderBy('end', 'desc')->first();
        $start = now();
        if($last_subscription && $last_subscription->end->gt($start)){
            $start = $last_subscription->end->addSecond();
        }
        $end = clone($start);
        $end->addDays($period);

        $subscription = new Subscription;
        $subscription->user_id = auth()->user()->id;
        $subscription->start = $start;
        $subscription->end = $end;
        $subscription->type = $type;

        $currency = Currency::firstOrCreate(['code'=>'USD'],['slug'=>'usd','name'=>'الدولار الامريكي','symbol'=>'$']);

        if($subscription->save()){
            $transaction = Transaction::payment_init($price, $currency, [
                'payment_method' => $request->payment_method
            ]);

            $subscription->transaction_id = $transaction->id;
            $subscription->save();

            if($request->payment_method == Transaction::PAYMENT_PAYPAL){
                $transaction->items = [[
                    'name' => $subscription_name,
                    'price' => ceil($transaction->amount_usd),
                    'desc' => $subscription_name,
                    'qty' => 1
                ]];
                $transaction->save();
                return $transaction->paypal_payment();
            }
            return $transaction->direct_payment();
        }
    }

    public function subscribed()
    {
        return view('store.subscribed');
    }
}
