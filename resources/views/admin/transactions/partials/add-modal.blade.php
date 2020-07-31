{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة عملية مالية جديدة </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/transactions/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
                        <label for="user" class="form-control-label"> المعاملة لحساب </label>
                        <div dir="ltr" class="text-left">
	                    	<select name="user" id="user" class=" select2" style="width: 100%;" required>
	                    		<option value=""> - </option>
	                    		@foreach (App\Models\User::get() as $user)
	                    			<option value="{{ $user->id }}">
	                    				{{ $user->id }}- {{ $user->name }} ({{ $user->username }})
	                    			</option>
	                    		@endforeach
	                    	</select>
                    	</div>
                    </div>

                    <div class="form-group">
                        <label for="transaction_type" class="form-control-label"> نوع المعاملة </label>
                    	<select name="transaction_type" id="transaction_type" class="form-control" required>
                    		<option value="{{ App\Models\Transaction::TYPE_DEPOSIT }}"> ايداع </option>
                    		<option value="{{ App\Models\Transaction::TYPE_WITHDRAWAL }}"> سحب </option>
                    	</select>
                    </div>

                    <div class="form-group">
                        <label for="amount" class="form-control-label"> المبلغ </label>
                        <input type="number" class="form-control" id="amount" name="amount" required placeholder="المبلغ" min="1">
                    </div>

                    <div class="form-group">
                        <label for="currency" class="form-control-label"> العملة </label>
                        <div dir="ltr" class="text-left">
	                    	<select name="currency" id="currency" class=" select2" style="width: 100%;" required>
	                    		<option value=""> - </option>
	                    		@foreach (App\Models\Currency::get() as $currency)
	                    			<option value="{{ $currency->id }}">
	                    				{{ $currency->id }}- {{ $currency->code }} ({{ $currency->name }})
	                    			</option>
	                    		@endforeach
	                    	</select>
                    	</div>
					</div>
					
                    <div class="form-group">
                        <label for="payment_method" class="form-control-label"> طريقة الدفع </label>
                    	<select name="payment_method" id="payment_method" class="form-control" required>
                    		<option value="{{ App\Models\Transaction::PAYMENT_BANK_DEPOSIT }}"> ايداع بنكي </option>
                    		<option value="{{ App\Models\Transaction::PAYMENT_FAWRY }}"> فوري </option>
                    		<option value="{{ App\Models\Transaction::PAYMENT_VODAFONE_CASH }}"> فودافون كاش </option>
                    		<option value="{{ App\Models\Transaction::PAYMENT_OTHER }}"> اخرى </option>
                    	</select>
                    </div>

                    <div class="form-group">
                        <label for="transaction_status" class="form-control-label"> حالة العملية </label>
                    	<select name="transaction_status" id="transaction_status" class="form-control" required>
                    		<option value="{{ App\Models\Transaction::STATUS_PENDING }}"> قيد المراجعة </option>
                    		<option value="{{ App\Models\Transaction::STATUS_PROCESSED }}"> مكتملة </option>
                    	</select>
                    </div>

				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
                    <button type="button" class="btn btn-success" data-dismiss="modal"> تراجع </button>
				</div> 
            </form>
		</div>
	</div>
</div>	