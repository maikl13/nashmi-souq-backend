<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Transaction;

trait PaymentTrait {

    public function payment_init($amount)
    {
        $transaction = new Transaction;
        $transaction->uid = uniqid();
        $transaction->amount = $amount;
        $transaction->user_id = auth()->user()->id;
        $transaction->type = Transaction::TYPE_PAYMENT;
        $transaction->status = Transaction::STATUS_PENDING;
        $transaction->payment_method = Transaction::PAYMENT_DIRECT_PAYMENT;
        if($transaction->save())
            return $transaction;
        return false;
    }

    public function pay($transaction, $options=[])
    {
        $uid = $transaction->uid;
        $address1 = $options['address1'] ?? 'NOT REQUIRED';
        $address2 = $options['address2'] ?? 'NOT REQUIRED';
        $description = $options['description'] ?? 'Ordered goods';
        $return_url = $options['return_url'] ?? config('app.url')."/payment-result?uid=$uid";
        $currency = $options['currency'] ?? 'EGP';

        // $params = $this->request_hosted_checkout_interaction($transaction->amount, $currency, $uid, $return_url);
        $params = [
            'result' => 'SUCCESS',
            'successIndicator' => 'abc',
            'session.id' => '123'
        ];

        if($params['result'] == 'SUCCESS'){
            if(!empty($params['session.id']) && !empty($params['successIndicator'])){
                $transaction->success_indicator = $params['successIndicator'];
                $transaction->save();

                return redirect()->to($return_url."&resultIndicator=abc");
                return view('main.payment.hosted-checkout')->with([
                    'session_id' => $params['session.id'],
                    'amount' => $transaction->amount,
                    'address1' => $address1,
                    'address2' => $address2,
                    'uid' => $uid,
                    'currency' => $currency,
                    'description' => $description,
                ]);
            }
        }
        dd('An Error Occured');
    }

    public function request_hosted_checkout_interaction($amount, $currency, $uid, $return_url)
    {
        $api_url = config('services.mpgs.api_url');
        $api_password = config('services.mpgs.api_password');
        $merchant_id = config('services.mpgs.merchant_id');
        $operation = config('services.mpgs.operation');
        $uid = $options['uid'] ?? uniqid();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "apiOperation=CREATE_CHECKOUT_SESSION&apiPassword=$api_password&apiUsername=merchant.$merchant_id&merchant=$merchant_id&interaction.operation=$operation&interaction.returnUrl=$return_url&order.id=$uid&order.amount=$amount&order.currency=EGP");
        $headers = array();
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch))
            echo 'Error:' . curl_error($ch);
        curl_close($ch);
        // $result = "merchant=EGPTEST1&result=SUCCESS&session.id=SESSION0002546338248G4885481I10&session.updateStatus=SUCCESS&session.version=ab91e73001&successIndicator=a1b488a6898c458d";
        $result_params = explode('&', $result);
        $params = [];
        foreach($result_params as $param) {
            $param_name = explode('=', $param)[0] ?? false;
            $param_value = explode('=', $param)[1] ?? false;
            if($param_name && $param_value) $params[$param_name] = $param_value;
        }

        return $params;
    }
}