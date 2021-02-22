@extends('admin.layouts.admin')

@section('title', 'تعديل صفة')

@section('head')

@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/options">الدول</a></li>
	<li class="breadcrumb-item active">تعديل دولة</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل صفة </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/options/{{ $option->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="option_selector" class="form-control-label"> الدولة :</label>
						<div dir="ltr">
							<input type="text" class="form-control text-right w-100" id="option" name="option" value="{{ old('option') }}" required>
							<input type="hidden" id="option_code" name="option_code" />
						</div>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $option->name }}" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
					<div class="form-group">
						<label for="delivery_phone" class="form-control-label"> رقم هاتف شركة الشحن :</label>
						<input type="text" class="form-control text-right" id="delivery_phone" name="delivery_phone" value="{{ old('delivery_phone') ? old('delivery_phone') : $option->delivery_phone }}" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
					<div class="form-group">
						<label for="currency" class="form-control-label"> عملة الدولة : </label>
						<select name="currency" id="currency" class="form-control">
							@foreach (App\Models\Currency::get() as $currency)
								<option value="{{ $currency->id }}" {{ $currency->id == $option->currency_id ? 'selected' : '' }}>{{ $currency->code }} - {{ $currency->name }}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> حفظ </button>
				</div> 
            </form>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="/admin-assets/plugins/option-picker-flags/build/js/optionSelect.min.js" type="text/javascript"r></script>
	<script> 
		$("#option").optionSelect({
			defaultOption: "{{ $option->code }}",
			preferredOptions: ['eg','sa','kw','jo','ae','sy','sd','tn','dz','ma','iq','ye','lb','ly','om','mr','qa','so','bh','dj','km','ps'],
			responsiveDropdown: true
		});
	</script>
@endsection