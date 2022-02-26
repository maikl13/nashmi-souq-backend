<div class="dropdown">
    <a id="cartDropdownMenuButton" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" 
        style="float: left; margin-top: -10px;"></a>
    <div class="dropdown-menu p-0 cart-dropdown-menu rounded" style="overflow: hidden;" aria-labelledby="cartDropdownMenuButton" dir="rtl">
        <div style="min-width: 400px; max-width: 100%; max-height: 300px; overflow-y: auto; overflow-x: hidden;">
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
        </div>
        <a class="btn btn-block btn-default bg-primary border-0 text-white rounded-0 p-3 text-center" style="font-size: 15px;" href="{{ route('cart', request()->store->store_slug) }}">تفاصيل عربة التسوق</a>
    </div>
</div>