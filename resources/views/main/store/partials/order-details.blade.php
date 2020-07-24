<div class="card m-b-20">
	<div class="card-header {{ isset($for_client) && $for_client ? 'bg-primary text-white' : '' }}">
		<h4 class="{{ isset($for_client) && $for_client ? 'my-4 text-white' : 'my-4' }}">بيانات الطلب</h4>
	</div>
	<div class="card-body">
		<div class="table-responsive ">
            <table class="table table-bordered cart-items">
                <thead>
                    <tr>
                        <th class="py-4"> المنتج </th>
                        <th class="py-4" title="Quantity"> الكمية </th>
                        <th class="py-4"> السعر </th>
                        <th class="py-4"> إجمالي </th>
                    </tr>
                </thead>
                <tbody>
                    <?php $listing = $order->listing; ?>
                    <tr data-product-id="{{ $listing->id }}">
                        <td>
                            <img src="{{ $listing->listing_image() }}" alt="{{ $order->title }} Image" style="height: 60px;">
                            <a href="{{ $listing->url() }}" target="_blank" style="color: #212529;"><span class="mr-2">{{ $order->title }}</span></a>
                        </td>
                        <td>
                            <div class="m-r10" style="width: 80px;">
                                <span class="w-100 text-center">{{ $order->quantity }}</span>
                            </div>
                        </td>
                        <td><span class="price">{{ $order->price() }}</span></td>
                        <td><span class="price">{{ $order->total_price() }}</span> ج م</td>
                    </tr>
                </tbody>
            </table>

            <table class="table table-bordered" style="max-width: 400px">
                <tbody>
                    <tr>
                        <td> إجمالي السعر </td>
                        <td>{{ $order->total_price() }} ج م</td>
                    </tr>
                    <tr>
                        <td>مصاريف الشحن</td>
                        <td><span class="order-shipping">{{ $order->shipping ?? '-' }}</span> ج م</td>
                    </tr>
                    <tr style="font-weight: bold;">
                        <td>الإجمالي</td>
                        <td>{{ $order->price + $order->taxes + $order->shipping }} 
                            <span class="currency-symbol" title="ب{{ $order->country->currency->name }}">{{ $order->country->currency->symbol }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        	{{-- <button class="btn btn-primary mt-2" onclick="window.print();">طباعه</button> --}}
		</div> 
	</div>
</div>