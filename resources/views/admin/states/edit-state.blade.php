@extends('admin.layouts.admin')

@section('title', 'تعديل مدينة')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/countries">الدول</a></li>
	<li class="breadcrumb-item"><a href="/admin/countries/{{ $country->slug }}/states">المدن</a></li>
	<li class="breadcrumb-item active">تعديل مدينة</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل المدينة </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/states/{{ $state->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $state->name }}" required>
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
				</div> 
            </form>
		</div>
	</div>
@endsection