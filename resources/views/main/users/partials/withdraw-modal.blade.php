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
			<div class="modal-body">
				<div class="alert alert-info">
					حدد المبلغ المراد سحبة و سيت التواصل معك من قبل ادارة الموقع خلال 24 ساعة.
				</div>
				<div class="alert alert-warning">لديك حاليا <strong>{{ Auth::user()->payout_balance() }}</strong> <small>{{ currency()->symbol }}</small> في رصيد المحفظة المتاح للسحب.</div>
				<div class="form-group">
					<label for="amount">المبلغ <small>ب{{ currency()->name }}</small></label>
					<input type="number" class="form-control" id="amount" name="amount" placeholder="المبلغ">
				</div>
			</div>
			<div class="modal-footer">
				<button type="submit" class="float-right btn btn-primary ml-2">طلب سحب</button>
				<button type="button" class="float-right btn btn-secondary" data-dismiss="modal">تراجع</button>
			</div>
		</form>
	</div>
</div>