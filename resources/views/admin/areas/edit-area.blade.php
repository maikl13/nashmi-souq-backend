@extends('admin.layouts.admin')

@section('title', 'تعديل منطقة')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/countries">الدول</a></li>
	<li class="breadcrumb-item"><a href="/admin/countries/{{ $state->country->slug }}/states">المدن</a></li>
	<li class="breadcrumb-item"><a href="/admin/states/{{ $state->slug }}/areas">المناطق</a></li>
	<li class="breadcrumb-item active">تعديل منطقة</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل المنطقة </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/areas/{{ $area->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $area->name }}" required>
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
				</div> 
            </form>
		</div>
	</div>
@endsection