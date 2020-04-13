{{-- Add Category Modal --}}
<div class="modal fade" id="change-status-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> تغيير حالة الإعلان </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/listings/{{ $listing->slug }}/change-status" method="POST" enctype="multipart/form-data" class="change-status-form">
            	@csrf()
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> حالة الإعلان :</label>
						<select name="status" id="status" class="form-control">
							<option value="{{ App\Models\Listing::STATUS_ACTIVE }}" {{ $listing->status == App\Models\Listing::STATUS_ACTIVE ? 'selected' : '' }}>فعال</option>
							<option value="{{ App\Models\Listing::STATUS_INACTIVE }}" {{ $listing->status == App\Models\Listing::STATUS_INACTIVE ? 'selected' : '' }}>غير فعال</option>
						</select>
					</div>
				</div>
				<div class="modal-body note" dir="rtl" {!! $listing->status == App\Models\Listing::STATUS_ACTIVE ? 'style="display: none;"' : '' !!}>
                    <div class="form-group">
						<label for="name" class="form-control-label"> سبب إلغاء تفعيل الإعلان :</label>
						<textarea name="note" id="" cols="7" class="form-control">{{ $listing->note }}</textarea>
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
