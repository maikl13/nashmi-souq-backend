<div class="dropdown ">
    <a id="cartDropdownMenuButton" class="nav-link color-primary" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre title="بيانات الحساب" style="font-size: 1.25rem">
        {{-- <i class="fa fa-shopping-cart"></i> --}}
        <img width="22" height="22" src="/assets/images/cart.svg" class="loaded">
        <span style="font-size: 14px; position: absolute; top: -5px; text-shadow: 0 0 5px white; left: 25px; font-weight: bold;">{{ cart()->total_quantity() ? cart()->total_quantity() : '' }}</span>
    </a>
    <div class="dropdown-menu p-0 " aria-labelledby="cartDropdownMenuButton" dir="rtl" style="width: 400px; min-width: 320px; max-height: 300px; overflow-y: auto; overflow-x: hidden;">
        @forelse( cart()->items() as $i => $item )
            <div class="media p-3">
                <div class="">
                    <span class="badge bg-primary text-white px-2 py-2 pull-right mt-2 ml-2" style="font-size: 11px; line-height: 11px; font-weight: normal;">{{ $item['quantity'] }}</span>
                </div>
                <div class="media-body">
                    <a class="border-0 d-inline-block px-0 py-2 float-right" href="{{ $item['url'] }}" style="line-height: 24px; height: auto; font-size: 16px; color: #646464;">
                        {{ $item['title'] }} 
                    </a>
                </div>
                <div>
                    <button type="button" class="close remove-from-cart py-2 pr-2" style="font-size: 20px; font-weight: normal;" data-product-id="{{ $i }}">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
            </div>
        @empty
            <div class="text-muted p-5 text-center">عربة التسوق فارغة.</div>
        @endforelse
        <a class="btn btn-block btn-default bg-primary border-0 text-white rounded-0 p-3 text-center" style="font-size: 15px;" href="{{ route('cart') }}">تفاصيل عربة التسوق</a>
    </div>
</div>