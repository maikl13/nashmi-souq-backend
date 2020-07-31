<?php $transaction = App\Models\Transaction::find($id); ?>

<a href="/admin/transactions/{{ $transaction->id }}/edit" class="btn btn-sm btn-info" > <i class="fa fa-edit" ></i> </a>

<a class="btn btn-primary btn-sm" title="preview" href="/admin/users/{{ $transaction->user->id }}">
	<i class="fa fa-address-card"></i>
</a>
<button type="button" class="btn btn-sm btn-danger delete" data-id="{{ $transaction->id }}"> <i class="fa fa-trash" ></i> </button>