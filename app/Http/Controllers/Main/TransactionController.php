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
            $transaction->status = Transaction::STATUS_PROCESSED;
            $transaction->save();
            $order = Order::where('transaction_id', $transaction->id)->first();
            if($order){
                $order->status = Order::STATUS_PROCESSING;
                $order->save();
            }
            return redirect()->route('order-saved');
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
        $transaction->currency_id = currency()->id;
        
        if($transaction->save()){
            return redirect()->back()
                ->with(['success' => 'تم تسجيل طلب السحب, سيتم التواصل معك في أقرب وقت ممكن.']);
        } else {
            return redirect()->back()
                ->with(['failure' => 'خطأ حدث خطأ ما من فضلك حاول مجددا.']);
        }
    }
}
