<?php

namespace App\Traits;

use App\Models\Transaction;
use Srmklive\PayPal\Services\ExpressCheckout;

trait PaymentTrait
{
    public static function payment_init($amount, $currency = false, $options = [])
    {
        $currency = $currency ? $currency : currency();
        $type = $options['type'] ?? Transaction::TYPE_PAYMENT;
        $payment_method = $options['payment_method'] ?? Transaction::PAYMENT_DIRECT_PAYMENT;
        $save = $options['save'] ?? true;

        $transaction = new Transaction;
        $transaction->uid = unique_id();
        $transaction->amount = $amount;
        $transaction->currency_id = $currency->id;

        session()->put('payment_method', $payment_method);

        if ($save) {
            if (auth()->user()) {
                $transaction->user_id = auth()->user()->id;
                $transaction->type = $type;
                $transaction->status = Transaction::STATUS_PENDING;
                $transaction->payment_method = $payment_method;
                if ($transaction->save()) {
                    return $transaction;
                }

                return false;
            } else {
                dd('Payment Failed, Please Sign in first');
            }
        }

        return $transaction;
    }

    public function direct_payment($options = [])
    {
        if (
            (auth()->check() && optional(auth()->user()->country)->code == 'sa') ||
            (auth()->guest() && optional(country())->code == 'sa') ||
            session('payment_method') == Transaction::PAYMENT_MADA
        ) {
            return $this->hyperpay_payment($options);
        }

        return $this->nbe_direct_payment($options);
    }

    public function nbe_direct_payment($options = [])
    {
        $address1 = $options['address1'] ?? 'NOT REQUIRED';
        $address2 = $options['address2'] ?? 'NOT REQUIRED';
        $description = $options['description'] ?? 'Ordered goods';
        $amount = exchange($this->amount, $this->currency->code, 'EGP');
        if (env('NBE_MPGS_MODE') == 'test') {
            $amount = ceil($amount);
        } else {
            $amount = round($amount, 2);
        }
        $params = $this->nbe_request_hosted_checkout_interaction($amount, $options);
        // $params = ['result' => 'SUCCESS','successIndicator' => 'abc','session.id' => '123'];
        if ($params['result'] == 'SUCCESS') {
            if (! empty($params['session.id']) && ! empty($params['successIndicator'])) {
                session()->put('success_indicator', $params['successIndicator']);

                if ($this->id) {
                    $this->success_indicator = $params['successIndicator'];
                    $this->save();
                }

                return view('main.payment.nbe-hosted-checkout')->with([
                    'session_id' => $params['session.id'],
                    'amount' => $amount,
                    'address1' => $address1,
                    'address2' => $address2,
                    'uid' => $this->uid,
                    'currency' => 'EGP',
                    'description' => $description,
                ]);
            }
        }
        dd('An Error Occured');
    }

    public function nbe_request_hosted_checkout_interaction($amount, $options)
    {
        $return_url = $options['return_url'] ?? url('/').'/payment-result?uid='.$this->uid;

        $api_url = config('services.nbe_mpgs.api_url').'/api/nvp/version/57';
        $api_password = config('services.nbe_mpgs.api_password');
        $merchant_id = config('services.nbe_mpgs.merchant_id');
        $operation = config('services.nbe_mpgs.operation');

        $data = http_build_query([
            'apiOperation' => 'CREATE_CHECKOUT_SESSION',
            'apiPassword' => $api_password,
            'apiUsername' => 'merchant.'.$merchant_id,
            'merchant' => $merchant_id,
            'interaction.operation' => $operation,
            'interaction.returnUrl' => $return_url,
            'order.id' => $this->uid,
            'order.amount' => $amount,
            'order.currency' => 'EGP',
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $headers = [];
        $headers[] = 'Content-Type: application/x-www-form-urlencoded';
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $result = curl_exec($ch);
        if (curl_errno($ch)) {
            echo 'Error:'.curl_error($ch);
        }
        curl_close($ch);
        // $result = "merchant=EGPTEST1&result=SUCCESS&session.id=SESSION0002546338248G4885481I10&session.updateStatus=SUCCESS&session.version=ab91e73001&successIndicator=a1b488a6898c458d";
        $result_params = explode('&', $result);
        $params = [];
        foreach ($result_params as $param) {
            $param_name = explode('=', $param)[0] ?? false;
            $param_value = explode('=', $param)[1] ?? false;
            if ($param_name && $param_value) {
                $params[$param_name] = $param_value;
            }
        }

        return $params;
    }

    public function hyperpay_payment($options = [])
    {
        $return_url = $options['return_url'] ?? url('/')."/hyperpay-payment-result?uid=$this->uid";
        $amount = exchange($this->amount, $this->currency->code, 'SAR');
        if (env('HYPERPAY_MODE') == 'test') {
            $amount = ceil($amount);
        } else {
            $amount = round($amount, 2);
            $amount = sprintf('%0.2f', $amount);
        }
        $params = $this->hyperpay_prepare_checkout($amount, $options, $return_url);
        $params = json_decode($params, true);

        if ($params['result']['code'] == '000.200.100') {
            if (! empty($params['id'])) {
                session()->put('success_indicator', $params['id']);

                if ($this->id) {
                    $this->success_indicator = $params['id'];
                    $this->save();
                }

                return view('main.payment.hyperpay-checkout')->with([
                    'return_url' => $return_url,
                    'checkout_id' => $params['id'],
                    'amount' => $amount,
                    'mada' => (session('payment_method') == Transaction::PAYMENT_MADA) ? true : false,
                ]);
            }
        }
        dd('An Error Occured');
    }

    public function hyperpay_prepare_checkout($amount, $options)
    {
        $address1 = $options['address1'] ?? 'NOT REQUIRED';
        $address2 = $options['address2'] ?? 'NOT REQUIRED';
        $description = $options['description'] ?? 'Ordered goods';

        $api_url = config('services.hyperpay.api_url').'/v1/checkouts';
        $access_token = config('services.hyperpay.access_token');
        $entity_id = (session('payment_method') == Transaction::PAYMENT_MADA) ? config('services.hyperpay.mada_entity_id') : config('services.hyperpay.entity_id');
        $ssl = config('services.hyperpay.ssl');
        $uid = $options['uid'] ?? uniqid();

        $data = http_build_query([
            'entityId' => $entity_id,
            'amount' => $amount,
            'currency' => 'SAR',
            'paymentType' => 'DB',
            'merchantTransactionId' => $this->uid,
            'customer.email' => optional(auth()->user())->email ?: 'user@example.com',
            'billing.street1' => $address1,
            'billing.city' => $address1,
            'billing.state' => $address1,
            'billing.country' => strtoupper(location()->code),
            'billing.postcode' => 12345,
            'customer.givenName' => optional(auth()->user())->name ?: 'User',
            'customer.surname' => optional(auth()->user())->username ?: 'User',
            'customer.mobile' => optional(auth()->user())->phone ?: '',
        ]);

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:Bearer '.$access_token]);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, $ssl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        return $responseData;
    }

    public function pay_from_wallet($transaction)
    {
        $transaction->type = Transaction::TYPE_EXPENSE;
        $transaction->payment_method = Transaction::PAYMENT_WALLET;
        if ($transaction->user->payout_balance() >= exchange($transaction->amount, $transaction->currency->code, currency()->code, true)) {
            $transaction->status = Transaction::STATUS_PROCESSED;

            return $transaction->save() ? $transaction : false;
        }

        return false;
    }

    public function paypal_payment($options = [])
    {
        // prepare paypal payment
        $provider = new ExpressCheckout;

        $logo = setting('logo') ? setting('logo') : 'logo';
        $options = [
            'BRANDNAME' => config('app.name'),
            'LOGOIMG' => config('url').'/'.$logo,
            'CHANNELTYPE' => 'Merchant',
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
        $data['invoice_description'] = $options['desc'] ?? 'مدفوعات لسوق نشمي عبر باي بال';
        $data['return_url'] = url('/').'/paypal-payment-result';
        $data['cancel_url'] = url()->previous();

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }
        $data['total'] = $total;

        return $data;
    }
}
