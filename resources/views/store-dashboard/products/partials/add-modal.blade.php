{{-- Add Category Modal --}}
<div class="modal fade" id="add-modal" tabindex="-1" role="dialog"  aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content text-right">
			<div class="modal-header">
				<h5 class="modal-title"> إضافة منتج جديد </h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <form action="/admin/products/" method="POST" enctype="multipart/form-data" class="add" id="wizard" novalidate>
            	@csrf()
				<div class="modal-body" dir="rtl">
					<div class="step d-block" data-step="1">
						@include('store-dashboard.products.partials.step1')
					</div>
					<div class="step d-none" data-step="2">
						@include('store-dashboard.products.partials.step2')
					</div>
					@if ($options->count())
						<div class="step d-none" data-step="3">
							@include('store-dashboard.products.partials.step3')
						</div>
					@endif
				</div>
				<div class="modal-footer"> 
					<button type="button" class="btn btn-primary previous d-none"><i class="fa fa-angle-right"></i> السابق </button>
					<button type="button" class="btn btn-primary next"> التالي <i class="fa fa-angle-left"></i></button>
					<button type="submit" class="btn btn-success submit d-none"> حفظ </button>
                    {{-- <button type="button" class="btn btn-success" data-dismiss="modal"> تراجع </button> --}}
				</div> 
				
				<div class="progress d-none" dir="rtl">
					<div class="progress-bar" role="progressbar" style="width: 0%" aria-valuemin="0" aria-valuemax="100"></div>
				</div>
            </form>
		</div>
	</div>
	
</div>

@include('store-dashboard.products.partials.partials')