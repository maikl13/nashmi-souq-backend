{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة بلد جديدة </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
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
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') }}" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="currency" class="form-control-label"> عملة الدولة : </label>
						<input type="text" class="form-control text-right" id="currency" name="currency" value="{{ old('currency') }}" placeholder="مثال: (الدولار الأمريكي - الجنيه الاسترليني)" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="currency_symbol" class="form-control-label"> اختصار/رمز للعملة : </label>
						<input type="text" class="form-control text-right" id="currency_symbol" name="currency_symbol" value="{{ old('currency_symbol') }}" placeholder="مثال: ($ - € - ج م - ﷼)" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="currency_code" class="form-control-label"> كود العملة :</label>
						<input type="text" class="form-control text-right" id="currency_code" name="currency_code" value="{{ old('currency_code') }}" placeholder="مثال: (USD - EUR - EGP - SAR)" required>
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