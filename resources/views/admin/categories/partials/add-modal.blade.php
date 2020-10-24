{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> اضافة قسم جديد </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/categories/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') }}" required>
					</div>
                    <div class="form-group">
						<label for="icon" class="form-control-label"> الأيقونة :</label>
						<input type="text" class="form-control text-right icon" id="icon" name="icon" value="" required autocomplete="off">
					</div>
                    <div class="form-group">
						<label for="category" class="form-control-label"> متفرع من :</label>
						<select name="category" class="form-control" id="category">
							<option value="">-</option>
							@foreach (App\Models\Category::whereNull('category_id')->get() as $cat)
								<option value="{{ $cat->id }}"><strong>{{ $cat->name }}</strong></option>
								@foreach ($cat->all_children() as $child)
									@php
										$prefix = '';
            							for ($i=1; $i < $child->level(); $i++) { $prefix .= '___'; }
									@endphp
									<option value="{{ $child->id }}">{{ $prefix }} {{ $child->name }}</option>
								@endforeach
							@endforeach
						</select>
					</div>
                    {{-- <div class="form-group">
						<label for="image" class="form-control-label"> الصورة :</label>
						<input type="file" id="image" name="image" value="{{ old('image') }}">
					</div> --}}
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
                    <button type="button" class="btn btn-success" data-dismiss="modal"> تراجع </button>
				</div> 
            </form>
		</div>
	</div>
</div>	