@extends('admin.layouts.admin')

@section('title', 'إرسال إشعار')

@section('breadcrumb')
	<li class="breadcrumb-item active">إرسال إشعار</li>
@endsection

@section('content')
	<div class="card">
		<div class="card-header text-right">
			<h4 class="d-inline float-right">إرسال اشعار</h4>
		</div>
		<div class="card-body">
            <form action="/admin/notifications/" method="POST" enctype="multipart/form-data" class="add">
            	@csrf()
				<div class="modal-body text-right" dir="rtl">
                    <div class="form-group">
						<label for="name" class="form-control-label"> الاشعار : </label>
                        <textarea class="form-control" name="notification" rows="10" required></textarea>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary"> إرسال </button>
				</div>
            </form>
		</div>
	</div>
@endsection



