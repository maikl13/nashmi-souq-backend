@extends('admin.layouts.admin')

@section('title', 'الإعلانات')

@section('head')
	<style>
		table thead th:nth-child(4),
		table tbody tr td:nth-child(4) {
            max-width: 170px;
            white-space: normal;
            overflow: hidden;
        }
	</style>
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item active">الإعلانات</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">الإعلانات</h4>

			<select class="type-filter form-control form-control-sm d-inline h-auto w-auto p-1 mr-2">
				<option value="">{{ __('All') }}</option>
				<option value="{{ App\Models\Listing::TYPE_SELL }}">بيع</option>
				<option value="{{ App\Models\Listing::TYPE_BUY }}">شراء</option>
				<option value="{{ App\Models\Listing::TYPE_EXCHANGE }}">إستبدال</option>
				<option value="{{ App\Models\Listing::TYPE_JOB }}">وظيفة</option>
				<option value="{{ App\Models\Listing::TYPE_RENT }}">إيجار</option>
			</select>

			<select class="country-filter form-control form-control-sm d-inline h-auto w-auto p-1 mr-2">
				<option value="">{{ __('All') }}</option>
				@foreach (App\Models\Country::select(['id', 'name'])->get() as $country)
					<option value="{{ $country->id }}">{{ $country->name }}</option>
				@endforeach
			</select>

			<select class="featured-filter form-control form-control-sm d-inline h-auto w-auto p-1 mr-2">
				<option value="">{{ __('All') }}</option>
				<option value="1">إعلان مميز</option>
			</select>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				{!! $dataTable->table(['class' => 'table table-bordered text-center text-nowrap'], true) !!}
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! $dataTable->scripts() !!}

	<script>
		$(document).on("change", '.type-filter',function(e){
			window.LaravelDataTables["data-table"].column(2).search( $(this).val() ).draw()
		});
		$(document).on("change", '.country-filter',function(e){
			window.LaravelDataTables["data-table"].column(5).search( $(this).val() ).draw()
		});
		$(document).on("change", '.featured-filter',function(e){
			window.LaravelDataTables["data-table"].column(7).search( $(this).val() ).draw()
		});
	</script>
@endsection