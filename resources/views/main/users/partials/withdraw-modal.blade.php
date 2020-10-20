<!-- Withdraw Modal -->
<div class="modal fade" id="make-transaction-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<form class="modal-content" method="POST" action="/withdraw">
			@csrf
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">سحب الرصيد</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			@if (auth()->user()->has_payout_method())
				<div class="modal-body">
					<div class="alert alert-info">
						حدد المبلغ المراد سحبة و سيت التواصل معك من قبل ادارة الموقع خلال 24 ساعة.
					</div>
					<div class="alert alert-warning">لديك حاليا <strong>{{ Auth::user()->payout_balance() }}</strong> <small>{{ currency()->symbol }}</small> في رصيد المحفظة المتاح للسحب.</div>
					<div class="form-group">
						<label for="amount">المبلغ <small>ب{{ currency()->name }}</small></label>
						<input type="number" class="form-control" id="amount" name="amount" placeholder="المبلغ">
					</div>
					<div class="form-group">
						<label for="payout_method">و سيلة السحب</label>
						<select name="payout_method" id="payout_method" class="form-control">
							@if (auth()->user()->bank_account)
								<option value="bank_account">حساب بنكي - {{ auth()->user()->bank_account }}</option>
							@endif
							@if (auth()->user()->paypal)
								<option value="paypal">باي بال - {{ auth()->user()->paypal }}</option>
							@endif
							@if (auth()->user()->vodafone_cash)
								<option value="vodafone_cash">فودافون كاش - {{ auth()->user()->vodafone_cash }}</option>
							@endif
							@if (auth()->user()->national_id)
								<option value="postal_office">البريد المصري - {{ auth()->user()->national_id }}</option>
							@endif
						</select>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="float-right btn btn-primary ml-2">طلب سحب</button>
					<button type="button" class="float-right btn btn-secondary" data-dismiss="modal">تراجع</button>
				</div>

			@else
				<div class="modal-body">
					<div class="alert alert-info">
						من فضلك قم بإضافة و سيلة لسحب الرصيد أولا.
						<a class="btn btn-info" data-toggle="tab" href="#payout-methods" role="tab" aria-selected="false" onclick="$('.modal').modal('hide')">وسائل سحب الرصيد</a>
					</div>
				</div>
			@endif

		</form>
		
	</div>
</div>