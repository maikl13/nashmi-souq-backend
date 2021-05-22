<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Order;

class TransactionController extends Controller
{
    public function payment_result(Request $request)
    {
        if(!isset($request->uid) || !isset($request->resultIndicator)) abort(500);

        $transaction = Transaction::where('uid', $request->uid)->firstOrFail();
        if($transaction->payment_method != Transaction::PAYMENT_DIRECT_PAYMENT) return;

        if($transaction->success_indicator === $request->resultIndicator){
            $transaction->status = Transaction::STATUS_PROCESSED;
            $transaction->save();
            return view('main.payment.payment-success');
        }
        return view('main.payment.payment-failed');
    }

    public function hyperpay_payment_result(Request $request)
    {
        if(!isset($request->uid) || !isset($request->resourcePath)) abort(500);

        $transaction = Transaction::where('uid', $request->uid)->firstOrFail();
        if($transaction->payment_method != Transaction::PAYMENT_DIRECT_PAYMENT) return;

        $access_token = config('services.hyperpay.access_token');
        $entity_id = config('services.hyperpay.entity_id');
        $ssl = config('services.hyperpay.ssl');
        $url = config('services.hyperpay.api_url').$request->resourcePath."?entityId=".$entity_id;
        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization:Bearer '.$access_token));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if(curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);

        if(isset($response['result']) && isset($response['result']['code']) && $response['result']['code'] == '000.100.110'){
            $transaction->status = Transaction::STATUS_PROCESSED;
            $transaction->save();
            return view('main.payment.payment-success');
        }
        return view('main.payment.payment-failed');
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
            'amount' => 'numeric|min:1|max:1000000'
        ]);
        $amount = $request->amount;
        $transaction = Transaction::payment_init($amount, currency(), ['type'=>Transaction::TYPE_DEPOSIT]);
        return $transaction->direct_payment([]);
    }
}
