@extends('admin.layouts.admin')

@section('title', 'المتاجر')

@section('breadcrumb')
	<li class="breadcrumb-item active">المتاجر</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">المتاجر</h4>
		</div>
		<div class="card-body">
			<div class="e-table">
				<div class="table-responsive table-lg">
					{!! $dataTable->table(['class' => 'table table-bordered text-center text-nowrap'], true) !!}
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! $dataTable->scripts() !!}
@endsection