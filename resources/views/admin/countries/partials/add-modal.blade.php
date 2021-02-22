<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة بلد جديدة </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			@if(!App\Models\Currency::count())
				<div class="modal-body text-center">
					<p>قم بإضافة عملات الدول أولا</p>

					<a href="{{ route('currencies') }}">العملات</a>
				</div>
			@else
				<form action="/admin/countries/" method="POST" enctype="multipart/form-data" class="add">
					@csrf()
					<div class="modal-body" dir="rtl">
						<div class="form-group">
							<label for="country_selector" class="form-control-label"> الدولة :</label>
							<div dir="ltr">
								<input type="text" class="form-control text-right w-100" id="country" name="country" value="{{ old('country') }}" required>
								<input type="hidden" id="country_code" name="country_code" />
							</div>
						</div>
						<div class="form-group">
							<label for="name" class="form-control-label"> الاسم :</label>
							<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') }}" required>
						</div>
						<div class="form-group">
							<label for="delivery_phone" class="form-control-label"> رقم هاتف شركة الشحن :</label>
							<input type="text" class="form-control text-right" id="delivery_phone" name="delivery_phone" value="{{ old('delivery_phone') }}" required>
						</div>
						<div class="form-group">
							<label for="currency" class="form-control-label"> عملة الدولة : </label>
							<select name="currency" id="currency" class="form-control">
								@foreach (App\Models\Currency::get() as $currency)
									<option value="{{ $currency->id }}">{{ $currency->code }} - {{ $currency->name }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="modal-footer">
						<button type="submit" class="btn btn-primary"> حفظ </button>
						<button type="button" class="btn btn-success" data-dismiss="modal"> تراجع </button>
					</div>
				</form>
			@endif


		</div>
	</div>
</div>
