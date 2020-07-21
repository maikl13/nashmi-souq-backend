<?php $user = App\Models\User::find($id); ?>

<a class="btn btn-info btn-sm" title="preview" href="{{ $user->url() }}">
	<i class="fa fa-eye"></i>
</a>
<a class="btn btn-primary btn-sm" title="preview" href="/admin/users/{{ $user->id }}">
	<i class="fa fa-address-card"></i>
</a>
	
@if(!$user->is_superadmin() && Auth::user()->id != $user->id)
    <button class="toggle-active-state btn btn-{{ $user->active ? 'warning' : 'primary' }} btn-sm" title="{{ $user->active ? 'deactivete' : 'activate' }}" data-id="{{ $user->id }}">
        <i class="fa fa-{{ $user->active ? 'close' : 'check' }}"></i>
    </button>
@endif
@if(Auth::user()->is_superadmin() && $user->is_admin() && !$user->is_superadmin())
    {{-- <button class="delete btn btn-danger btn-sm" title="delete" data-id="{{ $user->id }}">
    	<i class="fa fa-trash"></i>
    </button> --}}
@endif

@if(Auth::user()->is_superadmin() && !$user->is_superadmin())
	<div class="btn-group">
	    <button class="btn btn-primary btn-sm m-b-5 m-t-5 dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
	        <i class="fa fa-cog"></i> {{ __('Privileges') }}
	    </button>
	    <div class="dropdown-menu dropdown-menu-right text-right" style="width: 160px;" data-id="{{ $user->id }}">
	        <a class="dropdown-item py-1 change-role" href="#" data-role="{{ App\Models\User::ROLE_ADMIN }}"> {{ __('Admin') }} </a>
	        <div class="dropdown-divider"></div>
	        <a class="dropdown-item py-1 change-role" href="#" data-role="{{ App\Models\User::ROLE_USER }}"> {{ __('User') }} </a>
	    </div>
	</div>
@endif