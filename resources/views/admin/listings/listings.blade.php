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
@endsection