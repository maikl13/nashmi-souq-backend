{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة {{ optional($brand) ? 'موديل' : 'علامة تجارية' }} </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/states/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<input type="hidden" name="brand_id" value="{{ optional($brand)->id }}">
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') }}" required>
					</div>
					@if (!isset($brand))
						<div class="form-group">
							<label for="name" class="form-control-label"> الأقسام :</label>
							<select name="categories[]" id="categories" class=" select2" style="width: 100%;" required multiple>
								<option value=""> - </option>
								@foreach (App\Models\Category::whereNull('category_id')->get() as $category)
									<option value="{{ $category->id }}">{{ $category->name }}</option>
									@foreach ($category->all_children() as $sub_category)
										<?php 
											$prefix = '';
											for ($i=1; $i < $sub_category->level(); $i++) { $prefix .= '___'; }
										?>
										<option value="{{ $sub_category->id }}">{{ $prefix }}{{ $sub_category->name }}</option>
									@endforeach
								@endforeach
							</select>
						</div>
					@endif

				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"> حفظ </button>
                    <button type="button" class="btn btn-success" data-dismiss="modal"> تراجع </button>
				</div>
            </form>
		</div>
	</div>
</div>