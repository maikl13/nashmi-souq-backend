@extends('admin.layouts.admin')

@section('title', 'العمليات المالية')

@section('breadcrumb')
	<li class="breadcrumb-item active">العمليات المالية</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">العمليات المالية</h4>

			<select class="status-filter form-control form-control-sm d-inline h-auto w-auto p-1 mr-2">
				<option value="">{{ __('All') }}</option>
				<option value="{{ App\Models\Transaction::STATUS_PENDING }}">قيد المراجعة</option>
				<option value="{{ App\Models\Transaction::STATUS_PROCESSED }}">مكتملة</option>
			</select>

			<select class="type-filter form-control form-control-sm d-inline h-auto w-auto p-1 mr-2">
				<option value="">{{ __('All') }}</option>
				<option value="{{ App\Models\Transaction::TYPE_DEPOSIT }}">ايداع</option>
				<option value="{{ App\Models\Transaction::TYPE_WITHDRAWAL }}">سحب</option>
			</select>

			<select class="payment-method-filter form-control form-control-sm d-inline h-auto w-auto p-1 mr-2">
				<option value="">{{ __('All') }}</option>
				<option value="{{ App\Models\Transaction::PAYMENT_BANK_DEPOSIT }}">ايداع بنكي</option>
				<option value="{{ App\Models\Transaction::PAYMENT_FAWRY }}">فوري</option>
				<option value="{{ App\Models\Transaction::PAYMENT_VODAFONE_CASH }}">فودافون كاش</option>
				<option value="{{ App\Models\Transaction::PAYMENT_OTHER }}">اخرى</option>
			</select>

			<div class="float-left">
				<a class="btn btn-primary btn-sm" href="#" data-toggle="modal" data-target="#add-modal">
		            <i class="fa fa-plus"></i> {{ __('Add New Record') }}
		        </a>
	        </div>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				{!! $dataTable->table(['class' => 'table table-bordered text-center text-nowrap'], true) !!}
			</div>
		</div>
	</div>
@endsection

@section('modals')
	@include('admin.transactions.partials.add-modal')
@endsection

@section('scripts')
	{!! $dataTable->scripts() !!}
	<script> var records = 'transactions'; </script>
	<script src="/admin-assets/js/ajax/crud.js"></script>
	<script>
		$(document).on("change", '.status-filter',function(e){
			window.LaravelDataTables["data-table"].column(6).search( $(this).val() ).draw()
		});
		$(document).on("change", '.type-filter',function(e){
			window.LaravelDataTables["data-table"].column(3).search( $(this).val() ).draw()
		});
		$(document).on("change", '.payment-method-filter',function(e){
			window.LaravelDataTables["data-table"].column(5).search( $(this).val() ).draw()
		});
	</script>
@endsection