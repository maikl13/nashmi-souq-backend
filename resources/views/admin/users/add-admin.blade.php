@extends('admin.layouts.admin')

@section('title', 'إضافة مسئول')

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/ad(min/users">{{ __('Users') }}</a></li>
		<li class="breadcrumb-item active">{{ __('Add Admin') }}</li>
@endsection

@section('content')
	<div class="card" dir="rtl">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">{{ __('Add Admin') }}</h4>
		</div>
		<div class="card-body">
			<form action="/admin/admins/add" method="post" enctype="multipart/form-data">
				@csrf
				<div class="form-group">
					<div class="input-group">
						<input class="form-control" id="name" type="text" name="name" placeholder="{{ __('Name') }}" value="{{ old('name') }}">
					</div>
				</div>
				<div class="form-group">
					<div class="input-group">
						<input class="form-control" id="email" type="text" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}">
					</div>
				</div>
				<div class="form-group">
					<input class="form-control" id="password" type="password" name="password" placeholder="{{ __('Password') }}" value="{{ old('password') }}">
				</div>
				<div class="form-group">
					<input class="form-control" id="password_confirmation" type="password" name="password_confirmation" placeholder="{{ __('Password Confirmation') }}" value="{{ old('password_confirmation') }}">
				</div>
				<div class="form-group text-right" dir="rtl">
					<label for="profile_picture">{{ __('Profile Picture') }}</label>				
					<div class="">
						<input class="form-control profile-picture" id="profile_picture" type="file" accept="image/*" name="profile_picture">
					</div>
				</div>
				<div class="form-actions">
		            <button class="btn btn-primary" type="submit">{{ __('Add') }}</button>
		        </div>
			</form>
		</div>
	</div>
@endsection

@section('scripts')
	<script type="text/javascript">
		$("[type=file]").fileinput(fileInputOptions);
	</script>
@endsection