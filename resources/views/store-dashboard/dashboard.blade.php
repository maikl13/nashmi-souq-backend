@extends('store-dashboard.layouts.store-dashboard')

@section('title', 'لوحة ادارة المتجر')

@section('head')
@endsection

@section('content')
    
<div class="row">
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-primary text-white ">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 text-center">
                            <i class="ion-ios-browsers-outline" style="font-size: 43ypx;"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-3 text-center">
                            <span class="text-white"> المنتجات </span>
                            <h2 class="text-white mb-0">{{ App\Models\Product::count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 text-center">
                            <i class="ion-ios-cart-outline"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-3 text-center">
                            <span class="text-white"> الطلبات </span>
                            <h2 class="text-white mb-0">{{ App\Models\Order::count() }}</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 text-center">
                            <i class="ion-social-usd-outline"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-3 text-center">
                            <span class="text-white"> الرصيد المتاح </span>
                            <h2 class="text-white mb-0">
                                {{ round(auth()->user()->payout_balance(), 1) }} <small>{{ currency()->symbol }}</small>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 col-md-6 col-12">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <div class="icon1 text-center">
                            <i class="ion-social-usd-outline"></i>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mt-3 text-center">
                            <span class="text-white"> الرصيد المعلق </span>
                            <h2 class="text-white mb-0">
                                {{ round(auth()->user()->reserved_balance(), 1) }} <small>{{ currency()->symbol }}</small>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row row-deck">
    <div class="col">
        <div class="card" style="min-height: 500px;">
            <div class="card-status bg-success br-tr-3 br-tl-3"></div>
            <div class="card-header text-right">
                <h4 class="card-title">
                    احدث الطلبات
                    <a href="/dashboard/orders" class="btn btn-primary float-left">استعرض الطلبات</a>
                </h4>
            </div>
            <div class="table-responsive">
                <table class="table card-table table-vcenter text-center text-nowrap" dir="rtl">
                    <thead>
                        <tr class="bg-light"> 
                            <th> المشتري </th>
                            <th> السعر </th>
                            <th> طريقة الدفع </th>
                            <th> الحالة </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse( App\Models\Order::latest()->limit(7)->get() as $order )
                            <tr class="border-bottom"> 
                                <td> {{ $order->buyer_name }} </td>
                                <td> {{ $order->price }}  <small>{{ $order->currency->symbol }}</small></td>
                                <td> {{ $order->payment_method() }} </td>
                                <td> {{ $order->status() }} </td>
                            </tr>
                        @empty
                            <tr class="border-bottom">
                                <td colspan="4">لا يوجد طلبات حتى الآن</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@endsection