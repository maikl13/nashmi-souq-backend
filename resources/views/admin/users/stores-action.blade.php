<?php $user = App\Models\User::find($id); ?>

<a class="btn btn-primary btn-sm" title="preview" target="_blank" href="{{ $user->store_url() }}">
	<i class="fa fa-eye"></i> معاينة المتجر
</a>
<a class="btn btn-primary btn-sm" title="preview" href="/admin/users/{{ $user->id }}">
	<i class="fa fa-address-card"></i>
</a>