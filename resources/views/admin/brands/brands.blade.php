@extends('admin.layouts.admin')

@section('title', 'العلامات التجارية')

@section('breadcrumb')
	@if (isset($brand) && $brand)
		<li class="breadcrumb-item"><a href="/admin/brands">العلامات التجارية</a></li>
	@endif
	<li class="breadcrumb-item active">{{ isset($brand) ? $brand->name : 'العلامات التجارية' }}</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right" dir="rtl">
				@if (isset($brand) && $brand)
					{{ $brand->name }} - الموديلات
				@else
					العلامات التجارية
				@endif
			</h4>
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
	@include('admin.brands.partials.add-modal')
@endsection

@section('scripts')
	<script> $("[type=file]").fileinput(fileInputOptions); </script>
	{!! $dataTable->scripts() !!}
	<script> var records = 'brands'; </script>
	<script src="/admin-assets/js/ajax/crud.js"></script>
@endsection