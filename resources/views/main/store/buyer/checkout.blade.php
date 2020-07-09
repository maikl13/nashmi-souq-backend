@extends('main.layouts.main')

@section('title', 'إتمام الطلب')

@section('head')
	<style> 
        .cart-items tr:first-child .empty-cart-text {
            display: table-cell !important;
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
                        <h1>إتمام الطلب</h1>
                        <ul>
                            <li> <a href="/">الرئيسية</a> </li>
                            <li> <a href="/listings">المنتجات</a> </li>
                            <li> <a href="/cart">عربة التسوق</a> </li>
                            <li>إتمام الطلب</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- contact area -->
    <div class="single-product-wrap-layout1 section-padding-equal-70 bg-white">
        <div class="container">
            <form class="row" method="POST" action="/order/new">
                @method('POST')
                @csrf
                <!-- Left part start -->
                <div class="col-xs-12 col-md-7">
                    <div class="p-4 bg-gray clearfix mb-3">
                        <h3>بياناتك</h3>
                        <div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" required  placeholder="الإسم كاملا" name="name" value="{{ Auth::user()->name }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <input name="phone" type="tel" required class="form-control" placeholder="Phone" value="{{ Auth::user()->phone }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <select name="state" id="state" style="max-height: 300px;" required class="form-control">
                                            @foreach( country()->states()->get() as $state)
                                                <option value="{{ $state->id }}" {{ Auth::user()->state_id == $state->id ? 'selected' : '' }}>{{ $state->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <input type="text" class="form-control" required  placeholder="عنوان الشحن" name="address" value="{{ Auth::user()->shipping_address }}">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-3">
                                        <label for="payment" class="form-control-label">طريقة الدفع :</label>
                                        <select class="form-control" id="payment" name="payment_method">
                                            <option value="{{ App\Models\Order::CREDIT_PAYMENT }}">بطاقة إئتمانية</option>
                                            <option value="{{ App\Models\Order::ON_DELIVERY_PAYMENT }}">الدفع عند الإستلام</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Left part END -->

                <div class="col-xs-12 col-md-5">
                    <div class="p-4 bg-gray clearfix mb-3 ">
                        <h3>بيانات الطلب</h3>
                        <div class="row details">
                            <div class="col-lg-12"> 
                                <div class="table-responsive">
                                    <table class="table table-bordered cart-items">
                                        <thead>
                                            <tr>
                                                <th class="py-4">المنتج</th>
                                                <th class="py-4" title="Quantity">الكمية</th>
                                                <th class="py-4">السعر</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $not_editable = true; ?>
                                            @foreach ($cart->items() as $product_id => $product)
                                                @include('main.store.partials.cart-item')
                                            @endforeach
                                            <tr><td colspan="4" class="text-center text-muted empty-cart-text px-2 py-5" style="display: none;">{{ __('No products added') }}</td></tr>
                                        </tbody>
                                    </table>
                                </div>   
                            </div>
                            <div class="col-12 mt-4"> 
                                <div class="row"> 
                                    <div class="col-12">  
                                        <div class="table-responsive">
                                            @include('main.store.partials.totals')
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="row py-1">
                                            <div class="col-sm-12 mb-2"> 
                                                <button class="btn btn-success btn-block text-white py-3" type="submit">إتمام الطلب</button>
                                            </div>
                                            <div class="col-sm-12"> 
                                                <a class="btn btn-info btn-block text-white py-3" href="{{ route('cart') }}">العودة لعربة التسوق</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
            </form>
        </div>
    </div>
    <!-- contact area  END -->
@endsection

@section('scripts')
@endsection