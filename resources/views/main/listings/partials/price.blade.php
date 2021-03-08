@if ($listing->price !== null)
    <div class="widget-lg widget-price mb-3">
        <div class="item-price">
            {{ $listing->local_price() }}
            <small><span class="currency-symbol" title="ب{{ country()->currency->name }}">{{ country()->currency->symbol }}</span></small>
        </div>
    </div>
@endif
{{-- @if ($listing->is_eligible_for_cart())
    <div class="widget-lg widget-price widget-light-bg">
        <form method="post" class="cart-form">
            <input type="hidden" value="1" class="quantity" name="demo_vertical2"/>
            <input type="hidden" value="{{ $listing->id }}" class="product-id">
            <button class="btn btn-info btn-block text-right" type="submit">
                <i class="fa fa-cart-plus"></i> إضافة لعربة التسوق
            </button>
        </form>
    </div>
@endif --}}