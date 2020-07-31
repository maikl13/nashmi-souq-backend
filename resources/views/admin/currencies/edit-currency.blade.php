@extends('admin.layouts.admin')

@section('title', 'تعديل عملة')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/currencies">العملات</a></li>
	<li class="breadcrumb-item active">تعديل عملة</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل العملة </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/currencies/{{ $currency->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> اسم العملة: </label>
						<input type="text" class="form-control text-right" id="name" name="name" value="{{ old('name') ? old('name') : $currency->name }}" placeholder="مثال: (الدولار الأمريكي - الجنيه الاسترليني)" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="symbol" class="form-control-label"> اختصار/رمز للعملة : </label>
						<input type="text" class="form-control text-right" id="symbol" name="symbol" value="{{ old('symbol') ? old('symbol') : $currency->symbol }}" placeholder="مثال: ($ - € - ج م - ﷼)" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="code" class="form-control-label"> كود العملة :</label>
						<input type="text" class="form-control text-right" id="code" name="code" value="{{ old('code') ? old('code') : $currency->code }}" placeholder="مثال: (USD - EUR - EGP - SAR)" required>
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
				</div> 
            </form>
		</div>
	</div>
@endsection