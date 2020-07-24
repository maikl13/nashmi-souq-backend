@extends('admin.layouts.admin')

@section('title', 'تعديل دولة')

@section('head')
	<link rel="stylesheet" href="/admin-assets/plugins/country-picker-flags/build/css/countrySelect.min.css">
	<style>
		.country-select {width: 100%;}
		.country-select.inside .flag-dropdown {
		    right: 0;
		    left: auto;
		}
		.country-select.inside input, .country-select.inside input[type=text] {
		    padding-left: 6px;
		    padding-right: 52px;
		    margin-right: 0;
		}
		.country-select .country-list {
			right: 0;
    		direction: rtl;
    		min-width: 360px;
		}
		.country-select .country-list .country {
	    	text-align: right;
		}
		.country-select .country-list .flag {
		    margin-left: 6px;
		    margin-right: auto;
		}
	</style>
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/countries">الدول</a></li>
	<li class="breadcrumb-item active">تعديل دولة</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right" dir="rtl">
			<h4> تعديل الدولة </h4>
		</div>
		<div class="card-body text-right" dir="rtl">
			<form action="/admin/countries/{{ $country->slug }}/" method="POST" enctype="multipart/form-data">
            	@csrf()
            	@method('PUT')
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="country_selector" class="form-control-label"> الدولة :</label>
						<div dir="ltr">
							<input type="text" class="form-control text-right w-100" id="country" name="country" value="{{ old('country') }}" required>
							<input type="hidden" id="country_code" name="country_code" />
						</div>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاسم :</label>
						<input type="text" class="form-control" id="name" name="name" value="{{ old('name') ? old('name') : $country->name }}" required>
					</div>
				</div>
				<div class="modal-body" dir="rtl">
					<div class="form-group">
						<label for="currency" class="form-control-label"> عملة الدولة : </label>
						<select name="currency" id="currency" class="form-control">
							@foreach (App\Models\Currency::get() as $currency)
								<option value="{{ $currency->id }}" {{ $currency->id == $country->currency_id ? 'selected' : '' }}>{{ $currency->code }} - {{ $currency->name }}</option>
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
	<script src="/admin-assets/plugins/country-picker-flags/build/js/countrySelect.min.js" type="text/javascript"r></script>
	<script> 
		$("#country").countrySelect({
			defaultCountry: "{{ $country->code }}",
			preferredCountries: ['eg','sa','kw','jo','ae','sy','sd','tn','dz','ma','iq','ye','lb','ly','om','mr','qa','so','bh','dj','km','ps'],
			responsiveDropdown: true
		});
	</script>
@endsection