{{-- Add CategLarge Leaderboard - 970x90ory Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة بانر جديد </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/bs/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="type" class="form-control-label"> النوع :</label>
						<select name="type" id="type" class="form-control" required dir="ltr">
							<option value="{{ App\Models\Banner::TYPE_LARGE_RECTANGLE }}">
								Large Rectangle - 336x280
							</option>
							<option value="{{ App\Models\Banner::TYPE_LEADERBOARD }}">
								Leaderboard - 728x90
							</option>
							<option value="{{ App\Models\Banner::TYPE_LARGE_LEADERBOARD }}">
								Large Leaderboard - 970x90
							</option>
							<option value="{{ App\Models\Banner::TYPE_MOBILE_BANNER }}">
								Mobile Banner - 320x50
							</option>
						</select>
					</div>
                    <div class="form-group">
						<label for="url" class="form-control-label"> الرابط :</label>
						<input type="text" class="form-control text-right" id="url" name="url" value="" required>
					</div>
                    <div class="form-group">
						<label for="period" class="form-control-label"> المدة (بالأيام) :</label>
						<input type="number" class="form-control text-right" id="period" name="period" value="" required>
					</div>
                    <div class="form-group">
						<label for="countries" class="form-control-label"> الدول :</label>
						<select name="countries[]" id="countries" class="form-control select2" multiple dir="ltr">
							@foreach (\App\Models\Country::get() as $country)
								<option value="{{ $country->id }}">{{ $country->name }}</option>
							@endforeach
						</select>
					</div>
                    <div class="form-group">
						<label for="image" class="form-control-label"> الصورة :</label>
						<input type="file" id="image" name="image" value="{{ old('image') }}">
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