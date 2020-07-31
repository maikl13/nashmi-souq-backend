<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\DataTables\TransactionsDataTable;
use Str;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TransactionsDataTable $dataTable)
    {
        return $dataTable->render('admin.transactions.transactions');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'user' => 'exists:users,id',
            'currency' => 'exists:currencies,id',
            'transaction_type' => 'in:'.Transaction::TYPE_DEPOSIT.','.Transaction::TYPE_WITHDRAWAL,
            'payment_method' => 'in:'.Transaction::PAYMENT_BANK_DEPOSIT.','.Transaction::PAYMENT_FAWRY.','.Transaction::PAYMENT_VODAFONE_CASH.','.Transaction::PAYMENT_OTHER,
            'transaction_status' => 'in:'.Transaction::STATUS_PENDING.','.Transaction::STATUS_PROCESSED,
            'amount' => 'integer|min:1',
        ]);

        $transaction = new Transaction;
        $transaction->uid = strtoupper(substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, 8));
        $transaction->user_id = $request->user;
        $transaction->type = $request->transaction_type;
        $transaction->amount = $request->amount;
        $transaction->status = $request->transaction_status;
        $transaction->currency_id = $request->currency;
        $transaction->payment_method = $request->payment_method;

        if($transaction->save()){
            return response()->json('تم الحفظ بنجاح!', 200);
        }
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا.', 500);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        $this->authorize('edit', $transaction);
        
        return view('admin.transactions.edit-transaction')->with('transaction', $transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $this->authorize('edit', $transaction);

        $request->validate([
            'user' => 'exists:users,id',
            'transaction_type' => 'in:1,2',
            'currency' => 'exists:currencies,id',
            'amount' => 'integer',
        ]);

        $transaction->user_id = $request->user;
        $transaction->type = $request->transaction_type;
        $transaction->amount = $request->amount;
        $transaction->status = $request->transaction_status;
        $transaction->payment_method = $request->payment_method;
        $transaction->currency_id = $request->currency;

        if($transaction->save()){
            return redirect()->route('transactions')->with('success', 'تم تعديل البيانات بنجاح.');
        }
        return redirect()->back()->with('failure', 'حدث خطأ ما! من فضلك حاول مجددا.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaction  $transaction
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaction $transaction)
    {
        $this->authorize('delete', $transaction);

        if( $transaction->delete() )
            return response()->json('تم الحذف بنجاح.', 200);
        return response()->json('حدث خطأ ما! من فضلك حاول مجددا!', 500);
    }
}
