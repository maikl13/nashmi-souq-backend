@extends('admin.layouts.admin')

@section('title', __('Users'))

@section('breadcrumb')
	<li class="breadcrumb-item active">{{ __('Users') }}</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">{{ __('Users') }}</h4>

			<select class="filter form-control form-control-sm d-inline h-auto w-auto p-1 mr-2">
				<option value="">{{ __('All') }}</option>
				<option value="1">{{ __('Users') }}</option>
				<option value="2">{{ __('Admins') }}</option>
			</select>
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

@section('modals')
	<!-- Add Admin Modal -->
	<div class="modal fade" id="user-form-modal" tabindex="-1" role="dialog"  aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content text-right">
				<div class="modal-header">
					<h5 class="modal-title" id="example-Modal3">  تعديل بيانات العضو </h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
	            <form>
				<div class="modal-body">
					
						<div class="form-group">
							<label for="recipient-name" class="form-control-label">{{ __('Name') }} :</label>
							<input type="text" class="form-control text-right" id="recipient-name">
						</div>
	                    <div class="form-group">
							<label for="recipient-name" class="form-control-label">{{ __('Email') }} :</label>
							<input type="email" class="form-control text-right" id="recipient-name">
						</div>  
						<div class="form-group mb-0">
							<label for="message-text" class="form-control-label">{{ __('Password') }} :</label>
							<input type="input" class="form-control text-right" id="recipient-name">
						</div>
	                    <div class="form-group mb-0">
							<label for="message-text" class="form-control-label">{{ __('Password Confirmation') }} :</label>
							<input type="input" class="form-control text-right" id="recipient-name">
						</div>
				</div>
				<div class="modal-footer"> 
					<button type="submit" class="btn btn-primary"> {{ __('Save') }} </button>
	                <button type="button" class="btn btn-success" data-dismiss="modal"> {{ __('Cancel') }} </button>
				</div> 
	            </form>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	{!! $dataTable->scripts() !!}
	<script src="/admin-assets/js/ajax/users.js"></script>
@endsection