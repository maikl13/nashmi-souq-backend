<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Country;
use App\Models\Currency;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function payment_result(Request $request)
    {
        if (! isset($request->uid) || ! isset($request->resultIndicator)) {
            abort(500);
        }

        $payment_method = session('payment_method');
        $success_indicator = session('success_indicator');

        $transaction = Transaction::where('uid', $request->uid)->first();

        if ($transaction) {
            $payment_method = $transaction->payment_method;
            $success_indicator = $transaction->success_indicator;
        }

        if ($payment_method != Transaction::PAYMENT_DIRECT_PAYMENT) {
            return;
        }

        if ($success_indicator === $request->resultIndicator) {
            if ($transaction) {
                $transaction->status = Transaction::STATUS_PROCESSED;
                $transaction->save();
            }

            return response()->json(['success' => 'Payment completed successfully'], 200);
        }

        return response()->json(['error' => 'The payment process was not completed correctly, please try again.'], 200);
    }

    public function hyperpay_payment_result(Request $request)
    {
        if (! isset($request->uid) || ! isset($request->resourcePath)) {
            abort(500);
        }

        $payment_method = session('payment_method');

        $transaction = Transaction::where('uid', $request->uid)->first();

        if ($transaction) {
            $payment_method = $transaction->payment_method;
        }

        if (
            $payment_method != Transaction::PAYMENT_DIRECT_PAYMENT &&
            $payment_method != Transaction::PAYMENT_MADA
        ) {
            return;
        }

        $access_token = config('services.hyperpay.access_token');
        $entity_id = config('services.hyperpay.entity_id');
        if ($payment_method == Transaction::PAYMENT_MADA) {
            $entity_id = config('services.hyperpay.mada_entity_id');
        }

        $ssl = config('services.hyperpay.ssl');
        $url = config('services.hyperpay.api_url').$request->resourcePath.'?entityId='.$entity_id;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.$access_token]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response = json_decode($responseData, true);

        if (
            isset($response['result']) &&
            isset($response['result']['code']) &&
            in_array($response['result']['code'], ['000.100.110', '000.000.000'])
        ) {
            if ($transaction) {
                $transaction->status = Transaction::STATUS_PROCESSED;
                $transaction->save();
            }

            return response()->json(['success' => 'Payment completed successfully'], 200);
        } elseif (
            isset($response['result']) &&
            isset($response['result']['code']) &&
            in_array($response['result']['code'], ['200.300.404'])
        ) {
            return redirect()->route('home');
        }

        return response()->json(['error' => 'The payment process was not completed correctly, please try again.'], 200);
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
        if ($request->payout_method == 'bank_account') {
            $payment_method = Transaction::PAYMENT_BANK_DEPOSIT;
        }
        if ($request->payout_method == 'paypal') {
            $payment_method = Transaction::PAYMENT_PAYPAL;
        }
        if ($request->payout_method == 'postal_office') {
            $payment_method = Transaction::PAYMENT_POSTAL_OFFICE;
        }
        if ($request->payout_method == 'vodafone_cash') {
            $payment_method = Transaction::PAYMENT_VODAFONE_CASH;
        }
        $transaction->payment_method = $payment_method;
        $transaction->currency_id = currency()->id;

        if ($transaction->save()) {
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

    public function add_balance($code, Request $request)
    {
        $request->validate([
            'amount' => 'numeric|min:1|max:1000000',
            'payment_method' => 'in:'.Transaction::PAYMENT_DIRECT_PAYMENT.','.Transaction::PAYMENT_PAYPAL.','.Transaction::PAYMENT_MADA,
        ]);
        $country = Country::where('code', $code)->first();
        if ($country) {
            $codecurrency = Currency::where('id', $country->currency_id)->first();
        }
        $amount = $request->amount;
        $transaction = Transaction::payment_init($amount, $codecurrency, [
            'type' => Transaction::TYPE_DEPOSIT,
            'payment_method' => $request->payment_method,
        ]);
        if ($request->payment_method == Transaction::PAYMENT_PAYPAL) {
            $transaction_items = [[
                'name' => 'مدفوعات لسوق نشمي لشحن رصيد المحفظة',
                'price' => ceil($transaction->amount_usd),
                'desc' => 'مدفوعات لسوق نشمي لشحن رصيد المحفظة',
                'qty' => 1,
            ]];
            $transaction->items = $transaction_items;
            $transaction->save();

            return $transaction->paypal_payment_api();
        }
        if ($request->payment_method == Transaction::PAYMENT_MADA) {
            return $transaction->hyperpay_payment();
        }

        return $transaction->nbe_direct_payment();
    }

    public function make_direct_payment(Request $request)
    {
        $request->validate([
            'amount' => 'numeric|min:1|max:1000000',
            'payment_method' => 'in:'.Transaction::PAYMENT_DIRECT_PAYMENT.','.Transaction::PAYMENT_PAYPAL.','.Transaction::PAYMENT_MADA,
        ]);
        $amount = $request->amount;
        $transaction = Transaction::payment_init($amount, currency(), [
            'type' => Transaction::TYPE_DEPOSIT,
            'payment_method' => $request->payment_method,
            'save' => false,
        ]);
        if ($request->payment_method == Transaction::PAYMENT_PAYPAL) {
            $transaction_items = [[
                'name' => 'مدفوعات مباشرة لسوق نشمي',
                'price' => ceil($transaction->amount_usd),
                'desc' => 'مدفوعات مباشرة لسوق نشمي',
                'qty' => 1,
            ]];
            $transaction->items = $transaction_items;
            $transaction->save();

            return $transaction->paypal_payment();
        }

        return $transaction->direct_payment([]);
    }
}
