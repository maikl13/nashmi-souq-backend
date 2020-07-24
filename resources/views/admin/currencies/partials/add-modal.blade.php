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
            <form action="/admin/currencies/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> اسم العملة : </label>
						<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') }}" placeholder="مثال: (الدولار الأمريكي - الجنيه الاسترليني)" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="symbol" class="form-control-label"> اختصار/رمز للعملة : </label>
						<input type="text" class="form-control text-right" id="symbol" name="symbol" value="{{ old('symbol') }}" placeholder="مثال: ($ - € - ج م - ﷼)" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="code" class="form-control-label"> كود العملة :</label>
						<input type="text" class="form-control text-right" id="code" name="code" value="{{ old('code') }}" placeholder="مثال: (USD - EUR - EGP - SAR)" required>
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