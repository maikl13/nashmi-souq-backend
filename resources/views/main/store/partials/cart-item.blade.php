<tr data-product-id="{{ $product_id }}">
    @if( !isset($not_editable) || !$not_editable)
        <td class="text-center p-0">
            <button type="button" class="close remove-from-cart" style="font-size: 20px; float: unset; padding: 20px; width: 100%;" data-product-id="{{ $product_id }}">
                <span aria-hidden="true">×</span>
            </button>
        </td>
    @endif

    <td class="">
        @if( !isset($no_image) || !$no_image)
		  <img src="{{ $product['image'] }}" alt="{{ $product['title'] }} Image" style="height: 60px;">
        @endif
    	<a href="{{ $product['url'] }}" target="_blank" style="color: #212529;"><span class="ml-2">{{ $product['title'] }}</span></a>
    </td>
    <td>
		<div class="{{ !isset($not_editable) || !$not_editable ? 'btn-quantity' : '' }} m-r10" {!! !isset($not_editable) || !$not_editable ? 'style="width: 80px;"' : '' !!}>
            @if( isset($not_editable) && $not_editable)
                <span class="w-100 text-center">{{ $product['quantity'] }}</span>
            @else
                <input type="text" value="{{ $product['quantity'] }}" min="1" class="quantity" name="demo_vertical2" style="max-width: 90px; padding: 7px; border: 1px solid #ddd;"/>
            @endif
		</div>
	</td>
    @if( isset($view_item_price) && $view_item_price)
        <td><span class="price">{{ $product['price'] }}</span></td>
    @endif
    <td><span class="price">{{ $product['price']*$product['quantity'] }}</span> {{ $product['currency'] }}</td>
</tr>