<?php

namespace App\Http\Controllers\Store;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;
use Srmklive\PayPal\Services\ExpressCheckout;

class TransactionController extends Controller
{
    public function payment_result(Request $request)
    {
        if(!isset($request->uid) || !isset($request->resultIndicator)) abort(500);

        $transaction = Transaction::where('uid', $request->uid)->firstOrFail();
        if($transaction->success_indicator === $request->resultIndicator){
            $transaction->status = Transaction::STATUS_PROCESSED;
            $transaction->save();
            $order = Order::where('transaction_id', $transaction->id)->first();
            if($order){
                $order->status = Order::STATUS_PROCESSING;
                $order->save();
                return redirect()->route('order-saved', request()->store->store_slug);
            }
            return $request->store ? view('store.payment.payment-success', [$request->store->store_slug]) : view('main.payment.payment-success');
        }
        return $request->store ? view('store.payment.payment-failed', [$request->store->store_slug]) : view('main.payment.payment-failed');
    }

    public function paypal_payment_result(Request $request)
    {
        $provider = new ExpressCheckout;
        $response = $provider->getExpressCheckoutDetails($request->token);

        if($response['ACK'] != 'success' && $response['PAYERSTATUS'] != 'verified' || !$response['PAYERID'])
            return $request->store ? view('store.payment.payment-failed', [$request->store->store_slug]) : view('main.payment.payment-failed');

        $transaction = Transaction::where('uid', $response['INVNUM'])->first();

        if($transaction){
            $data = $transaction->paypal_invoice_data();
            $response = $provider->doExpressCheckoutPayment($data, $response['TOKEN'], $response['PAYERID']);

            if($response['ACK'] == 'Success' && $response['PAYMENTINFO_0_PAYMENTSTATUS'] == 'Completed' && $response['PAYMENTINFO_0_ACK'] == 'Success') {
                $transaction->amount_usd = $response['PAYMENTINFO_0_AMT'];
                $transaction->success_indicator = $response['TOKEN'];
                $transaction->transaction_id = $response['PAYMENTINFO_0_TRANSACTIONID'];
                $transaction->status = Transaction::STATUS_PROCESSED;
            }

            if( $transaction->save() ){
                $order = Order::where('transaction_id', $transaction->id)->first();
                if($order){
                    $order->status = Order::STATUS_PROCESSING;
                    $order->save();
                    return redirect()->route('order-saved', request()->store->store_slug);
                }
                return $request->store ? view('store.payment.payment-success', [$request->store->store_slug]) : view('main.payment.payment-success');
            }
        }

        return $request->store ? view('store.payment.payment-failed', [$request->store->store_slug]) : view('main.payment.payment-failed');
    }

    public function withdraw(Request $request)
    {
        $payout_balance = auth()->user()->payout_balance();
        $request->validate([
            'amount' => 'integer|min:1|max:'.$payout_balance,
        ]);

        $transaction = new Transaction;
        $transaction->uid = unique_id();
        $transaction->user_id = auth()->user()->id;
        $transaction->type = Transaction::TYPE_WITHDRAWAL;
        $transaction->amount = $request->amount;
        $transaction->status = Transaction::STATUS_PENDING;
        $payment_method = null;
        if($request->payout_method == 'bank_account') $payment_method = Transaction::PAYMENT_BANK_DEPOSIT;
        if($request->payout_method == 'paypal') $payment_method = Transaction::PAYMENT_PAYPAL;
        if($request->payout_method == 'postal_office') $payment_method = Transaction::PAYMENT_POSTAL_OFFICE;
        if($request->payout_method == 'vodafone_cash') $payment_method = Transaction::PAYMENT_VODAFONE_CASH;
        $transaction->payment_method = $payment_method;
        $transaction->currency_id = currency()->id;
        
        if($transaction->save()){
            return redirect()->back()
                ->with(['success' => 'تم تسجيل طلب السحب, سيتم التواصل معك في أقرب وقت ممكن.']);
        } else {
            return redirect()->back()
                ->with(['failure' => 'خطأ حدث خطأ ما من فضلك حاول مجددا.']);
        }
    }

    
    public function add_balance_page()
    {
        // $balance = [];
        // $balance['expensed_balance'] = auth()->user()->expensed_balance(true);
        // $balance['reserved_balance'] = auth()->user()->reserved_balance(true);
        // $balance['payout_balance'] = auth()->user()->payout_balance(true);
        // dd($balance);

        return view('main.payment.add-balance');
    }

    public function add_balance(Request $request)
    {
        $request->validate([
            'amount' => 'integer|min:1|max:1000000'
        ]);
        $amount = $request->amount;
        $transaction = Transaction::payment_init($amount, currency(), ['type'=>Transaction::TYPE_DEPOSIT]);
        return $transaction->direct_payment();
    }
    
    public function direct_payment()
    {
        return view('main.payment.direct-payment');
    }

    public function make_direct_payment(Request $request)
    {
        $request->validate([
            'amount' => 'integer|min:1|max:1000000'
        ]);
        $amount = $request->amount;
        $transaction = Transaction::payment_init($amount, currency(), ['type'=>Transaction::TYPE_DEPOSIT]);
        return $transaction->direct_payment(['return_url'=>false]);
    }
}
