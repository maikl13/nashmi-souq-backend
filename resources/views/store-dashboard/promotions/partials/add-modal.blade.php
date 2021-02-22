{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> إضافة عرض ترويجي </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/promotions/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="url" class="form-control-label"> رابط المنتج :</label>
						<input type="text" class="form-control text-right" id="url" name="url" value="{{ old('url') }}" required>
					</div>
                    <div class="form-group">
						<label for="image" class="form-control-label"> صورة العرض :</label>
						<div class="img-gallery">
							<input class="form-control image" id="image" type="file" accept="image/*" name="image" required>
							<div class="img-upload-instruction alert alert-danger mt-3" style="opacity: .7;"><small>الحد الأقصى لحجم الصور <span dir="ltr">8 MB</span>.</small></div>
						</div>
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