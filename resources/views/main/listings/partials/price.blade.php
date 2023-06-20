@if ($listing->price !== null)
    {{-- <div class="widget-lg widget-price mb-3">
        <div class="item-price">
            {{ $listing->local_price() }}
            <small><span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span></small>
        </div>
    </div> --}}
    <div class="widget-lg widget-price mb-3">
        <div class="item-price">
            {{ preg_replace('/(\.00$)/i', '', number_format($listing->price(), 2)) }}
            @if ($listing->currency)
                <small><span class="currency-symbol" title="ب{{ $listing->currency->name }}">{{ $listing->currency->symbol }}</span></small>
            @endif
        </div>
    </div>
@endif