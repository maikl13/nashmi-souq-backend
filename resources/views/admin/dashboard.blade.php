@extends('admin.layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="col">
		<div class="card text-right" dir="rtl">
			<div class="card-header">
				<h4> {{ __('Admin Dashboard') }} </h4>
			</div>

            <div class="card-body">
                Hello from the other side
            </div>
        </div>
    </div>
@endsection
