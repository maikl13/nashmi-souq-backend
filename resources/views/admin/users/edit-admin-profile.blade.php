@extends('admin.layouts.admin')

@section('title', __('Edit').' '.__('User Profile').$admin->name)

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/profile">{{ __('User Profile') }}</a></li>
	<li class="breadcrumb-item active">{{ __('Edit') }}</li>
@endsection

@section('content')
	<div class="card text-right" dir="rtl">
		<div class="card-header">
			<h4> {{ __('Account Settings') }} </h4>
		</div>
		<div class="card-body">
			<div class="row">
				<div class="col-12 col-sm-12 col-lg-3">
					<ul class="nav nav-pills flex-column pr-0" id="myTab4" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" id="home-tab4" data-toggle="tab" href="#home4" role="tab" aria-controls="home" aria-selected="true"> {{ __('Edit') }} {{ __('Account Settings') }} </a>
						</li>
						<li class="nav-item">
							<a class="nav-link" id="contact-tab4" data-toggle="tab" href="#contact4" role="tab" aria-controls="contact" aria-selected="false"> {{ __('Change Password') }} </a>
						</li>
					</ul>
				</div>
				<div class="col-12 col-sm-12 col-lg-9">
					<div class="tab-content border p-3" id="myTab3Content">
						<div class="tab-pane fade show active p-0" id="home4" role="tabpanel" aria-labelledby="home-tab4">
	                        <div class="card">
	                            <div class="card-header text-right">
	                                <h4> {{ __('Edit') }} {{ __('Account Settings') }} </h4>
	                            </div>
	                            <div class="card-body">
									<form action="/admin/profile/edit" method="post" enctype="multipart/form-data" class="edit">
										@csrf
										@method('put')
										<div class="form-group">
											<div class="input-group">
												<input class="form-control" id="name" type="text" name="name" placeholder="{{ __('name') }}" value="{{ old('name') ? old('name') : $admin->name }}">
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<input class="form-control" id="email" type="text" name="email" placeholder="{{ __('Email') }}" value="{{ old('email') ? old('email') : $admin->email }}">
											</div>
										</div>
										<div class="form-group">
											<div class="text-right">
												<input class="form-control profile-picture" id="profile_picture" type="file" name="profile_picture" accept="image/*">
											</div>
										</div>
										<div class="form-group">
											<div class="input-group">
												<input class="form-control" id="password" type="password" name="password" placeholder="{{ __('Current Password') }}" value="">
											</div>
										</div>
										<div class="form-actions">
								            <button class="btn btn-primary float-left" type="submit">{{ __('Edit') }}</button>
								        </div>
									</form>
	                            </div>
	                        </div>
	                    </div>
						<div class="tab-pane fade p-0" id="contact4" role="tabpanel" aria-labelledby="contact-tab4">
	                        <div class="card">
	                            <div class="card-header text-right">
	                                <h4> {{ __('Change Password') }}  </h4>
	                            </div>
	                            <div class="card-body">
									<form action="/admin/profile/change-password" method="post" class="change-password edit">
										@csrf
										@method('put')
										<div class="form-group">
											<input class="form-control" type="password" name="password" placeholder="{{ __('Current Password') }}" value="{{ old('password') }}">
										</div>
										<div class="form-group">
											<input class="form-control" id="new_password" type="password" name="new_password" placeholder="{{ __('New Password') }}" value="{{ old('new_password') }}">
										</div>
										<div class="form-group">
											<input class="form-control" id="new_password_confirmation" type="password" name="new_password_confirmation" placeholder="{{ __('Password Confirmation') }}" value="{{ old('new_password_confirmation') }}">
										</div>
										<div class="form-actions">
								            <button class="btn btn-primary float-left" type="submit">{{ __('Change') }}</button>
								        </div>
									</form>
	                            </div>
	                        </div>
	                    </div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection

@section('scripts')
	<script src="/admin-assets/js/ajax/profile.js"></script>

	<script type="text/javascript">
		@if(Auth::user()->profile_picture)
			var profile_picture = '{{ Auth::user()->profile_picture() }}';
			var fileInputOptions = $.extend(true,{
				initialPreview: [profile_picture],
				initialPreviewConfig : [{caption: "Profile Picture"}],
	        	deleteUrl: "/profile-picture/delete",
			},fileInputOptions);
		@endif

		var profilePicture = $("[type=file].profile-picture").fileinput(fileInputOptions);

		profilePicture.on('filedeleted', function(event, key, jqXHR, data) {
		    $('img.profile-picture').attr('src', '{{ Auth::user()->profile_picture(true) }}' );
		});
	</script>
@endsection