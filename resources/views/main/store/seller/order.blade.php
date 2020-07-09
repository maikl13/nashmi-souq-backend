@extends('main.layouts.main')

@section('title', 'تفاصيل الطلب #'.$order->uid)

@section('head')
    <link rel="stylesheet" type="text/css" href="/admin-assets/plugins/jquery-labelauty-master/source/jquery-labelauty.css">
    <style type="text/css">
        input.labelauty + label {width: 49%; display: inline-block; font-size: 13px; padding: 12px 10px 17px;}
        input.labelauty:checked + label,
        input.labelauty:checked:not([disabled]) + label:hover { background-color: #f85c70; }
        div#recaptcha-element>div { padding: 1px; }
        input.labelauty + label > span.labelauty-unchecked-image + span.labelauty-unchecked, input.labelauty + label > span.labelauty-checked-image + span.labelauty-checked { margin-right: 7px; }
        .status-details { display: none; }
        input.labelauty[disabled] + label { opacity: 1;}
    </style>
@endsection

@section('content')
    <!--=====================================-->
    <!--=        Inner Banner Start         =-->
    <!--=====================================-->
    <section class="inner-page-banner" data-bg-image="/assets/images/banner/banner1.jpg">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumbs-area">
                        <h1>بيانات الطلب #{{ $order->uid }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/orders">الطلبات</a> </li>
                            <li>طلب #{{ $order->uid }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
		<div class="container">
			<div class="row text-center" dir="rtl">
				<div class="col-lg-12 order-status-updates-log">
					@include('main.store.partials.order-status-updates')
				</div>

				<div class="col-lg-6 order-details text-right">
					@include('main.store.partials.order-details')
				</div>
				<div class="col-lg-6 buyer-details">
					@include('main.store.partials.buyer-details')
				</div>
			</div>
		</div>
	</div>
@endsection


@section('modals')
    @if(!$order->is_cancelled_by_buyer())
    	{{-- Change Order Status Modal --}}
    	<div class="modal fade" id="change-status-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    		<div class="modal-dialog modal-lg" role="document">
    			<div class="modal-content text-right">
    				<div class="modal-header">
    					<h5 class="modal-title" id="example-Modal3"> تغيير حالة الطلب </h5>
    					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
    						<span aria-hidden="true">&times;</span>
    					</button>
    				</div>
                    <form action="/orders/change-status" method="POST" enctype="multipart/form-data" class="change-status-form position-relative">
                    	@csrf()
                    	<div class="overlay text-center text-white w-100 h-100 position-absolute" style="background: rgba(0,0,0,0.7);  z-index: 10; font-size: 22px; display: none;">
                    		<i class="fa fa-spinner fa-spin fa-lg position-relative" style="top: 44%;"></i>
                    	</div>
                    	<input type="hidden" name="order_id" value="{{ $order->id }}">

    					<div class="modal-body change-status-options" dir="rtl">
    						@include('main.store.partials.change-status-options')
    					</div>
    					<div class="modal-footer"> 
    						<button type="submit" class="btn btn-primary"> حفظ </button>
    	                    <button type="button" class="btn btn-success mr-2" data-dismiss="modal"> إغلاق </button>
    					</div> 
    	            </form>
    			</div>
    		</div>
    	</div>
    @endif
@endsection


@section('scripts')
    @if(!$order->is_cancelled_by_buyer())
        <script src="/admin-assets/plugins/jquery-labelauty-master/source/jquery-labelauty.js"></script>
    	<script src="/assets/js/ajax/order.js"></script>
        <script>
            $(document).ready(function(){
                $(":radio.labelauty").labelauty();
            });

            $(document).on('change', ':radio[name=order_status]', function(e){
                $('.status-details').hide();
                $('[required]').attr('required', false);
                $('.'+ $(this).val() +'-details').show();
                $('.'+ $(this).val() +'-details .required').attr('required', true);
            });
        </script>
    @endif
@endsection