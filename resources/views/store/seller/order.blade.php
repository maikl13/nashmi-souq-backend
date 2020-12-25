@extends('main.layouts.main')

@section('title', 'تفاصيل الطلب #'.$package->uid.'@'.$order->uid)

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
    <style>
        @media print {
            header, footer { display: none;}
            #invoice {
                background-color: white; height: 100%; width: 100%; position: fixed; top: 0;
                left: 0; margin: 0; padding: 15px; font-size: 14px; line-height: 18px;
                z-index: 99999;
            }
        }
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
                        <h1>بيانات الطلب #{{ $package->uid }}</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/orders">الطلبات</a> </li>
                            <li>طلب #{{ $package->uid }}{{ '@'.$order->uid }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
		<div class="container">
			<div class="text-center" dir="rtl">
                <div class="row">
                    <div class="col-lg-12 package-status-updates-log">
                        @include('store.partials.package-status-updates')
                        <div class="clearfix mb-3"></div>
                    </div>
                </div>
                <div class="col-xs-12" id="invoice">
                    <div class="row">
                        <div class="col-lg-6 package-details text-right">
                            @include('store.partials.package-details')
                        </div>
                        <div class="col-lg-6 buyer-details">
                            @include('store.partials.buyer-details')
                        </div>
                    </div>
                </div>
				<div class="col-xs-12 w-100 mt-3">
                    <div class="col text-center bg-white p-3">
                        <button class="btn btn-info" onclick="window.print();"><i class="fa fa-print"></i> طباعة الفاتورة</button>
                    </div>
                </div>
			</div>
		</div>
	</div>
@endsection


@section('modals')
    @if(!$package->is_cancelled_by_buyer())
    	{{-- Change Order Status Modal --}}
    	<div class="modal fade" id="change-status-modal" tabindex="-1" role="dialog"  aria-hidden="true">
    		<div class="modal-dialog modal-lg" role="document">
    			<div class="modal-content text-right border-0">
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
                    	<input type="hidden" name="package_id" value="{{ $package->id }}">

    					<div class="modal-body change-status-options" dir="rtl">
    						@include('store.partials.change-status-options')
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
    @if(!$package->is_cancelled_by_buyer())
        <script src="/admin-assets/plugins/jquery-labelauty-master/source/jquery-labelauty.js"></script>
    	<script src="/assets/js/ajax/order.js"></script>
        <script>
            $(document).ready(function(){
                $(":radio.labelauty").labelauty();
            });

            $(document).on('change', ':radio[name=package_status]', function(e){
                $('.status-details').hide();
                $('[required]').attr('required', false);
                $('.'+ $(this).val() +'-details').show();
                $('.'+ $(this).val() +'-details .required').attr('required', true);
            });
        </script>
    @endif
@endsection