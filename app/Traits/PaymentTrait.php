<?php

namespace App\Traits;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Currency;
use Srmklive\PayPal\Services\ExpressCheckout;

trait PaymentTrait {

    public static function payment_init($amount, $currency=false, $options=[])
    {
        $currency = $currency ? $currency : currency();
        $type = $options['type'] ?? Transaction::TYPE_PAYMENT;
        $payment_method = $options['payment_method'] ?? Transaction::PAYMENT_DIRECT_PAYMENT;

        $transaction = new Transaction;
        $transaction->uid = unique_id();
        $transaction->amount = $amount;
        $transaction->currency_id = $currency->id;

        if(auth()->user()){
            $transaction->user_id = auth()->user()->id;
            $transaction->type = $type;
            $transaction->status = Transaction::STATUS_PENDING;
            $transaction->payment_method = $payment_method;
            if($transaction->save())
                return $transaction;
            return false;
        }
        return $transaction;
    }

    public function direct_payment($options=[])
    {
        $transaction = $this;
        $uid = $transaction->uid;
        $address1 = $options['address1'] ?? 'NOT REQUIRED';
        $address2 = $options['address2'] ?? 'NOT REQUIRED';
        $description = $options['description'] ?? 'Ordered goods';
        $return_url = $options['return_url'] ?? url('/')."/payment-result?uid=$uid";
        $currency = $options['currency'] ?? 'EGP';
        $amount = ceil(exchange($transaction->amount, $transaction->currency->code, $currency));
        $params = $this->request_hosted_checkout_interaction($amount, $currency, $uid, $return_url);
        // $params = [
        //     'result' => 'SUCCESS',
        //     'successIndicator' => 'abc',
        //     'session.id' => '123'
        // ];
        if($params['result'] == 'SUCCESS'){
            if(!empty($params['session.id']) && !empty($params['successIndicator'])){
                if(auth()->user()){
                    $transaction->success_indicator = $params['successIndicator'];
                    $transaction->save();
                }

                // return redirect()->to($return_url."&resultIndicator=abc");
                // header('Set-Cookie: cross-site-cookie=name; SameSite=None; Secure');
                return view('main.payment.hosted-checkout')->with([
                    'session_id' => $params['session.id'],
                    'amount' => $amount,
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
        $api_url = config('services.mpgs.api_url').'/api/nvp/version/57';
        $api_password = config('services.mpgs.api_password');
        $merchant_id = config('services.mpgs.merchant_id');
        $operation = config('services.mpgs.operation');
        $uid = $options['uid'] ?? uniqid();
        $interaction_return_url = $return_url ? "interaction.returnUrl=$return_url&" : '';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, "apiOperation=CREATE_CHECKOUT_SESSION&apiPassword=$api_password&apiUsername=merchant.$merchant_id&merchant=$merchant_id&interaction.operation=$operation&{$interaction_return_url}order.id=$uid&order.amount=$amount&order.currency=EGP");
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

    public function pay_from_wallet($transaction)
    {
        $transaction->type = Transaction::TYPE_EXPENSE;
        $transaction->payment_method = Transaction::PAYMENT_WALLET;
        if($transaction->user->payout_balance() >= exchange($transaction->amount, $transaction->currency->code, currency()->code, true)){
            $transaction->status = Transaction::STATUS_PROCESSED;
            return $transaction->save() ? $transaction : false;
        }
        return false;
    }

    public function paypal_payment($options=[])
    {
        // prepare paypal payment
        $provider = new ExpressCheckout;

        $logo = setting('logo') ? setting('logo') : 'logo';
        $options = [
            'BRANDNAME' => config('app.name'),
            'LOGOIMG' => config('url').'/'.$logo,
            'CHANNELTYPE' => 'Merchant'
        ];
        $provider->addOptions($options);

        $data = $this->paypal_invoice_data();
        $response = $provider->setExpressCheckout($data);

        return redirect($response['paypal_link']);
    }

    public function paypal_invoice_data()
    {
        $data = [];
        $data['items'] = $this->items;

        $data['invoice_id'] = $this->uid;
        $data['invoice_description'] = $options['desc'] ?? "مدفوعات لسوق نشمي عبر باي بال";
        $data['return_url'] = url('/')."/paypal-payment-result";
        $data['cancel_url'] = url()->previous();

        $total = 0;
        foreach($data['items'] as $item) {
            $total += $item['price']*$item['qty'];
        }
        $data['total'] = $total;

        return $data;
    }
}