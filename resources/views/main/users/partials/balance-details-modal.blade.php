<div class="modal fade" id="balance-details-modal" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content" >
			<div class="modal-header">
				<h5 class="modal-title" id="balanceModalLabel">تفاصيل الرصيد</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<table class="w-100">
					@foreach (auth()->user()->payout_balance(true) as $currency => $balance)
						@if ($balance)
							@php
								$currency = App\Models\Currency::where('code', $currency)->first();
							@endphp
							@if ($currency)
								<tr class="py-3">
									<td> الرصيد ب <strong>{{ $currency->name }}:</strong></td>
									<td>{{ $balance }} {{ $currency->symbol }}</td>
									@if ($currency->id != currency()->id)
										<td><i class="fa fa-exchange-alt"></i></td>
										<td>{{ App\Models\User::exchange($balance, $currency->code, currency()->code) }} {{ currency()->symbol }}</td>
									@endif	
								</tr>
							@endif
						@endif
					@endforeach
				</table>
			</div>
		</div>
	</div>
</div>