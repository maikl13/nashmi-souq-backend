@extends('admin.layouts.admin')

@section('title', 'تعديل عملية مالية')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/transactions">العمليات المالية</a></li>
	<li class="breadcrumb-item active">تعديل عملية مالية</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل العملية المالية </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/transactions/{{ $transaction->id }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
					<div class="form-group">
                        <label for="user" class="form-control-label"> المعاملة لحساب </label>
                        <div dir="ltr" class="text-left">
	                    	<select name="user" id="user" class=" select2" style="width: 100%;" required>
	                    		<option value=""> - </option>
	                    		@foreach (App\Models\User::get() as $user)
	                    			<option value="{{ $user->id }}" {{ $transaction->user_id == $user->id ? 'selected' : '' }}>
	                    				{{ $user->id }}- {{ $user->name }} ({{ $user->username }})
	                    			</option>
	                    		@endforeach
	                    	</select>
                    	</div>
                    </div>

                    <div class="form-group">
                        <label for="transaction_type" class="form-control-label"> نوع المعاملة </label>
                    	<select name="transaction_type" id="transaction_type" class="form-control" required>
                    		<option value="{{ App\Models\Transaction::TYPE_DEPOSIT }}" {{ $transaction->type == App\Models\Transaction::TYPE_DEPOSIT ? 'selected' : '' }}> ايداع </option>
                    		<option value="{{ App\Models\Transaction::TYPE_WITHDRAWAL }}" {{ $transaction->type == App\Models\Transaction::TYPE_WITHDRAWAL ? 'selected' : '' }}> سحب </option>
                    	</select>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="form-control-label"> المبلغ </label>
                        <input type="number" class="form-control" id="amount" name="amount" required placeholder="المبلغ" min="1" value="{{ old('amount') ? old('amount') : $transaction->amount }}">
					</div>
					
                    <div class="form-group">
                        <label for="currency" class="form-control-label"> العملة </label>
                        <div dir="ltr" class="text-left">
	                    	<select name="currency" id="currency" class=" select2" style="width: 100%;" required>
	                    		<option value=""> - </option>
	                    		@foreach (App\Models\Currency::get() as $currency)
	                    			<option value="{{ $currency->id }}" {{ $transaction->currency_id == $currency->id ? 'selected' : '' }}>
	                    				{{ $currency->id }}- {{ $currency->code }} ({{ $currency->name }})
	                    			</option>
	                    		@endforeach
	                    	</select>
                    	</div>
					</div>

                    <div class="form-group">
                        <label for="payment_method" class="form-control-label"> طريقة الدفع </label>
                    	<select name="payment_method" id="payment_method" class="form-control" required>
                    		<option value="{{ App\Models\Transaction::PAYMENT_BANK_DEPOSIT }}" {{ $transaction->payment_method == App\Models\Transaction::PAYMENT_BANK_DEPOSIT ? 'selected' : '' }}> ايداع بنكي </option>
                    		<option value="{{ App\Models\Transaction::PAYMENT_FAWRY }}" {{ $transaction->payment_method == App\Models\Transaction::PAYMENT_FAWRY ? 'selected' : '' }}> فوري </option>
                    		<option value="{{ App\Models\Transaction::PAYMENT_VODAFONE_CASH }}" {{ $transaction->payment_method == App\Models\Transaction::PAYMENT_VODAFONE_CASH ? 'selected' : '' }}> فودافون كاش </option>
                    		<option value="{{ App\Models\Transaction::PAYMENT_OTHER }}" {{ $transaction->payment_method == App\Models\Transaction::PAYMENT_OTHER ? 'selected' : '' }}> اخرى </option>
                    	</select>
                    </div>

                    <div class="form-group">
                        <label for="transaction_status" class="form-control-label"> حالة العملية </label>
                    	<select name="transaction_status" id="transaction_status" class="form-control" required>
                    		<option value="{{ App\Models\Transaction::STATUS_PENDING }}" {{ $transaction->status == App\Models\Transaction::STATUS_PENDING ? 'selected' : '' }}> قيد المراجعة </option>
                    		<option value="{{ App\Models\Transaction::STATUS_PROCESSED }}" {{ $transaction->status == App\Models\Transaction::STATUS_PROCESSED ? 'selected' : '' }}> مكتملة </option>
                    	</select>
                    </div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
				</div> 
            </form>
		</div>
	</div>
@endsection