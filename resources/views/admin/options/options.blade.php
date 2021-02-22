@extends('admin.layouts.admin')

@section('title', 'صفات المنتجات')

@section('head')
@endsection

@section('breadcrumb')
	<li class="breadcrumb-item active">صفات المنتجات</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">صفات المنتجات</h4>
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
	@include('admin.options.partials.add-modal')
@endsection

@section('scripts')
	<script> $("[type=file]").fileinput(fileInputOptions); </script>
	{!! $dataTable->scripts() !!}
	<script> var records = 'options'; </script>
	<script src="/admin-assets/js/ajax/crud.js"></script>
@endsection