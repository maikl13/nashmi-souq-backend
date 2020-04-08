@extends('admin.layouts.admin')

@section('title', __('User Profile').' - '.$user->name)

@section('breadcrumb')
	<li class="breadcrumb-item"><a href="/admin/users">{{ __('Users') }}</a></li>
	<li class="breadcrumb-item active">{{ __('User Profile') }}</li>
@endsection

@section('content')
<div class="card">
	<div class="card-header text-right">
		<h4 class="d-inline float-right">{{ __('User Profile') }}</h4>
		@if($user->id == Auth::user()->id)
			<div class="float-left">
				<a href="/admin/profile/edit" class="btn btn-primary btn-sm">
					<i class="fa fa-pencil-square-o"></i> {{ __('Edit') }} {{ __('Account Settings') }}
				</a>
	        </div>
        @endif
	</div>
	<div class="card-body" dir="rtl">
	    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 float-right text-right">
	        <aside>
	            <figure style="overflow: hidden; border:">
	            	<img src="{{ $user->profile_picture() }}" width="150">
	            </figure>
	            <div class="clearfix"></div> <br>
	        </aside>
	    </div>
	    <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10 float-right text-right" style="line-height: 30px;">
			<span><strong>{{ __('Name') }}:</strong> {{ $user->name }}</span><br>
			<span><strong>{{ __('Email') }}:</strong> {{ $user->email }}</span><br>
			<span><strong>{{ __('Role') }}:</strong> {{ $user->role() }}</span><br>
			<span><strong>{{ __('Registered At') }}:</strong> {{ $user->created_at->diffForHumans() }}</span><br>
			<span><strong>عدد الإعلانات:</strong> {{ $user->listings()->count() }}</span><br><br>
		</div>
	</div>
</div>
@endsection
