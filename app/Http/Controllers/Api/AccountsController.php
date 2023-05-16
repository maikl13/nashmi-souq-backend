<?php

namespace App\Http\Controllers\Api;

use Str;
use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Country;
use Validator;

class AccountsController extends Controller
{ 
  public function membership_report($code){
      $country = Country::where('code', $code)->first();
     $user=Auth::user();
     //return $user;
       return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status(),
            'profile_picture' => $user->profile_picture(),
            'created_at' => $user->created_at->format('d-m-Y h:i:s'),
            'created_at_diff' => $user->created_at->diffForHumans(),
            'payout_balance' => $user->payout_balance(),
            'reserved_balance' => $user->reserved_balance(),
            'expensed_balance' => $user->expensed_balance(),
            'currency' => $country->currency->symbol,
        ]);
      
  } 
  
  
  public function financial_transactions(){
      $user=Auth::user();
      $transactions = $user->transactions()->latest()->get();
     $data = $transactions->map(function ($transaction) {
        return [
            'code' => $transaction->uid,
            'type'=>$transaction->type(),
            'amount' => $transaction->amount,
            'currency'=>$transaction->currency->symbol,
            'get_payment_method'=>$transaction->get_payment_method(),
            'status' => $transaction->status(),
            'created_at' => $transaction->created_at->toIso8601String(),
        ];
    });
    
       if($data){
    return response()->json($data);
       }else{
            return response()->json('message','لا يوجد أي معاملات مالية حتى الآن');
       }
}


 public function payout(Request $request){
     // Validate the form data
        $request->validate([
            'bank_account' => 'nullable|string',
            'paypal' => 'nullable|email',
            'vodafone_cash' => 'nullable|string',
            'national_id' => 'nullable|string',
            'national_id_card' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        // Update the user's payout methods
        $user = auth()->user();
        $user->bank_account = $request->input('bank_account');
        $user->paypal = $request->input('paypal');
        $user->vodafone_cash = $request->input('vodafone_cash');
        $user->national_id = $request->input('national_id');
        if ($request->hasFile('national_id_card')) {
            $user->national_id_card = $request->file('national_id_card')->store('national_id_cards');
        }
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Payout methods updated successfully'
        ]);
 }
 
  
  
}
