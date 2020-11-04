@extends('admin.layouts.admin')

@section('title', __('Admin Dashboard'))

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
                                <span class="text-white"> إعلانات </span>
                                <h2 class="text-white mb-0">{{ App\Models\Listing::count() }}</h2>
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
                                <i class="ion-ios-people-outline"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3 text-center">
                                <span class="text-white"> المستخدمين </span>
                                <h2 class="text-white mb-0">{{ App\Models\User::count() }}</h2>
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
                                <i class="ion-ios-cart-outline"></i>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="mt-3 text-center">
                                <span class="text-white"> المتاجر </span>
                                <h2 class="text-white mb-0">{{ App\Models\User::whereNotNull('store_name')->count() }}</h2>
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
                                <span class="text-white"> الأرباح </span>
                                <?php
                                    $price = 0;
                                    foreach (App\Models\FeaturedListing::get() as $l) {
                                        $price += $l->transaction ? $l->transaction->amount_usd : 0;
                                    }
                                ?>
                                <h2 class="text-white mb-0">{{ round($price, 2) }}</h2>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="row row-deck">
        <div class="col-6">
            <div class="card">
                <div class="card-status bg-success br-tr-3 br-tl-3"></div>
                <div class="card-header text-right">
                    <h4 class="card-title">احدث الأعضاء</h4>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-center text-nowrap" dir="rtl">
                        <thead>
                            <tr class="bg-light"> 
                                <th> الاسم </th>
                                <th> البريد الالكتروني </th>
                                <th> تاريخ التسجيل </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( App\Models\User::where('role_id', App\Models\User::ROLE_USER )->latest()->limit(7)->get() as $user )
                                <tr class="border-bottom"> 
                                    <td> {{ $user->name }} </td>
                                    <td> {{ $user->email }} </td>
                                    <td dir="ltr">{{ $user->created_at->format('d M, Y') }}</td>
                                </tr>
                            @empty
                                <tr class="border-bottom">
                                    <td colspan="3">لا يوجد أعضاء حتى الآن</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="card">
                <div class="card-status bg-success br-tr-3 br-tl-3"></div>
                <div class="card-header text-right">
                    <h4 class="card-title">احدث الإعلانات</h4>
                </div>
                <div class="table-responsive">
                    <table class="table card-table table-vcenter text-center text-nowrap" dir="rtl">
                        <thead>
                            <tr class="bg-light"> 
                                <th> النوع </th>
                                <th> العنوان </th>
                                <th> <i class="fa fa-gear"></i> </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse( App\Models\Listing::latest()->limit(7)->get() as $listing )
                                <tr class="border-bottom"> 
                                    <td> {{ $listing->type() }} </td>
                                    <td> {{ $listing->title }} </td>
                                    <td dir="ltr"><a href="{{ $listing->url() }}" class="btn btn-sm btn-info" style="line-height: 16px;" target="_blank"> <i class="fa fa-eye" ></i> </a></td>
                                </tr>
                            @empty
                                <tr class="border-bottom">
                                    <td colspan="3">لا يوجد إعلانات حتى الآن</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection