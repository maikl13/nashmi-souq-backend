@extends('store.layouts.store')

@section('title', __('Shopping Cart'))

@section('head')
	<style> 
        .page-content { background: white; }
        .cart-items tr:first-child .empty-cart-text {
            display: table-cell !important;
        }
        .btn-quantity {width: 65px;}
        #demo_vertical2, .quantity {padding: 6px 7px 6px 2px; border-left: none !important;}
        .bootstrap-touchspin .input-group-btn-vertical{position:relative;white-space:nowrap;width:unset;vertical-align:middle;display:table-cell}
        .bootstrap-touchspin .input-group-btn-vertical>.btn{display:block;float:none;width:100%;max-width:100%;padding:9px 10px 9px;margin-left:-1px;position:relative;border-width:1px;border-style:solid;border-color:#e1e1e1;background:#fff}
        .bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-up{border-radius:0;border-top-right-radius:0}
        .bootstrap-touchspin .input-group-btn-vertical .bootstrap-touchspin-down{margin-top:-2px;border-radius:0;border-bottom-right-radius:0}
        .bootstrap-touchspin .input-group-btn-vertical i{position:absolute;top:4px;left:5px;font-size:9px;color:#9fa0a1}
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
                        <h1>عربة التسوق</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/products">المنتجات</a> </li>
                            <li>عربة التسوق</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact area -->
    <div class="single-product-wrap-layout1 section-padding-equal-70 bg-accent">
        <!-- Career -->
        <div class="container">
            <div class="row">
                <div class="col-md-12 details-cont text-center">
                    <div class="row details">
                         <div class="col-lg-12"> 
                            <div class="table-responsive">
                                <table class="table table-bordered cart-items">
                                    <thead>
                                        <tr>
                                            <th class="py-4"></th>
                                            <th class="py-4"> المنتج </th>
                                            <th class="py-4" style="width: 50px;"> الكمية </th>
                                            <th class="py-4">السعر </th>
                                        </tr>
                                    </thead>
                                    <tbody>  
                                    	@foreach ($cart->items() as $product_id => $product)
    	                                    @include('store.partials.cart-item')
                                        @endforeach
                                        <tr><td colspan="4" class="text-center text-muted empty-cart-text px-2 py-5" style="display: none;">عربة التسوق فارغة</td></tr>
                                    </tbody>
                                </table>
                            </div>   
    			        </div>
                        <div class="col-12 mt-4"> 
                            <div class="row"> 
                                <div class="col-lg-4 col-md-5 col-sm-12">  
                                    <div class="table-responsive">
                                        @include('store.partials.totals')
                                    </div>
                                </div>

                                <div class="col-lg-4 col-md-2 col-sm-12"></div>

                                <div class="col-lg-4 col-md-5 col-sm-12">
                                    <div class="row py-1">
                                        <div class="col-sm-12 mb-2"> 
                                            <a class="btn btn-success btn-block text-white py-3" href="{{ route('checkout', request()->store->store_slug) }}">إستكمال الطلب</a>
                                        </div> 
                                        <div class="col-sm-12"> 
                                            <a class="btn btn-info btn-block text-white py-3" href="/products" >متابعة التسوق</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </div>
        </div>
        <!-- Career END -->
    </div>
    <!-- contact area END -->
@endsection

@section('scripts')
    <script src="/assets/plugins/bootstrap-touchspin/jquery.bootstrap-touchspin.js" defer></script>
    <script>$(document).ready(function(e){$("input[name='demo_vertical2']").TouchSpin({verticalbuttons:!0,verticalupclass:"fa fa-plus",verticaldownclass:"fa fa-minus"});});</script>
@endsection