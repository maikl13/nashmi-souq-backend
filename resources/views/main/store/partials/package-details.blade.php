<div class="card m-b-20 h-100">
    @if (!isset($for_client) || !$for_client)
        <div class="card-header">
            <h4 class="my-4">بيانات الشحنة #{{ $package->uid }}{{ '@'.$order->uid }}</h4>
        </div>
    @endif
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
                    @foreach ($package->package_items as $item)
                        <?php $listing = $item->listing; ?>
                        <tr data-product-id="{{ $listing->id }}">
                            <td>
                                <img src="{{ $listing->listing_image() }}" alt="{{ $item->title }} Image" width="80">
                                <a href="{{ $listing->url() }}" target="_blank" style="color: #212529;"><span class="mr-2">{{ $item->title }}</span></a>
                            </td>
                            <td>
                                <div class="m-r10" style="width: 80px;">
                                    <span class="w-100 text-center">{{ $item->quantity }}</span>
                                </div>
                            </td>
                            <td><span class="price">{{ $item->price() }}</span></td>
                            <td><span class="price">{{ $item->total_price() }}</span> ج م</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <table class="table table-bordered" style="max-width: 400px">
                <tbody>
                    {{-- <tr>
                        <td> إجمالي السعر </td>
                        <td>{{ $package->price() }} ج م</td>
                    </tr>
                    <tr>
                        <td>مصاريف الشحن</td>
                        <td><span class="package-shipping">{{ $package->shipping ?? '-' }}</span> ج م</td>
                    </tr> --}}
                    <tr>
                        <td>إجمالي السعر</td>
                        <td>{{ $package->price() }} 
                            <span class="currency-symbol" title="ب{{ $package->order->currency->name }}">{{ $package->order->currency->symbol }}</span>
                        </td>
                    </tr>
                </tbody>
            </table>
		</div> 
	</div>
</div>
