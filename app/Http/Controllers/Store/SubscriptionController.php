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
        if (auth()->user()->is_active_store()) {
            return redirect()->route('store-dashboard', auth()->user()->store_slug);
        }
        return view('main.store.subscribe');
    }

    public function store(Request $request)
    {
        $request->validate([
            'subscription_type' => 'in:1,2,3',
            'payment_method' => 'in:'.Transaction::PAYMENT_DIRECT_PAYMENT.','.Transaction::PAYMENT_PAYPAL,
        ]);

        switch ($request->subscription_type) {
            case 2:
                $period = 183;
                $price = setting('half_year_subscription');
                $subscription_name = 'إشتراك نصف سنوي في المتاجر المدفوعة من سوق نشمي';
                break;
            case 3:
                $period = 365;
                $price = setting('yearly_subscription');
                $subscription_name = 'إشتراك سنوي في المتاجر المدفوعة من سوق نشمي';
                break;
            default:
                $period = 30;
                $price = setting('monthly_subscription');
                $subscription_name = 'إشتراك شهري في المتاجر المدفوعة من سوق نشمي';
                break;
        }

        $subscription = new Subscription;
        $subscription->start = now();
        $subscription->end = now()->addDays($period);
        $subscription->type = Subscription::TYPE_TRIAL;

        $currency = Currency::firstOrCreate(['code'=>'USD'],['slug'=>'usd','name'=>'الدولار الامريكي','symbol'=>'$']);

        if($subscription->save()){
            $transaction = Transaction::payment_init($price, $currency, [
                'payment_method' => $request->payment_method
            ]);
            
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
}
