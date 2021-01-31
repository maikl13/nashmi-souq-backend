@extends('store-dashboard.layouts.store-dashboard')

@section('title', 'إشتراكاتي')

@section('breadcrumb')
	<li class="breadcrumb-item active">إشتراكاتي</li>
@endsection

@section('content')
	@if (!request()->store->is_active_store())
		@include('store-dashboard.subscriptions.partials.subscribe')
	@endif

	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">إشتراكاتي</h4>
		</div>
		<div class="card-body">
			<div class="table-responsive">
				{!! $dataTable->table(['class' => 'table table-bordered text-center text-nowrap'], true) !!}
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script> $("[type=file]").fileinput(fileInputOptions); </script>
	{!! $dataTable->scripts() !!}
@endsection