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
        if($transaction->success_indicator === $request->resultIndicator){
            $order = Order::where('transaction_id', $transaction->id)->first();
            if($order){
                $order->status = Order::STATUS_PROCESSING;
                $order->save();
            }
            return redirect()->route('order-saved');
        }
        return view('main.payment.payment-failed');
    }
}
