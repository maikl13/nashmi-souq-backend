<table class="table totals mb-3">
    @if($total_price = $cart->total_price())
        {{-- @php
            $fees = $cart->fees();
            $taxes = $cart->taxes();
            $shipping = $cart->shipping();
            $discount = $cart->discount();
        @endphp --}}

        <tbody>
            {{-- @if ($fees || $taxes || $shipping || $discount)
                <tr>
                    <td>إجمالي السعر</td>
                    <td>{{ $total_price }}</td>
                </tr>
            @endif --}}
            {{-- @if($fees)
                <tr>
                    <td> رسوم </td>
                    <td>{{ $cart->fees() }}</td>
                </tr>
            @endif --}}
            {{-- @if($taxes)
                <tr>
                    <td title="Value-added tax"> ضريبة VAT (14%)</td>
                    <td>{{ $cart->taxes() }}</td>
                </tr>
            @endif --}}
            {{-- @if($shipping)
                <tr>
                    <td>تكلفة الشحن</td>
                    <td>{{ $shipping }}</td>
                </tr>
            @endif --}}
            {{-- @if($discount)
                <tr>
                    <td>خصم</td>
                    <td>{{ $discount }}</td>
                </tr>
            @endif --}}
            <tr>
                <td>إجمالي السعر</td>
                <td>{{ $total_price }} <span style="font-weight: normal;">{{ country()->currency->symbol }}</span></td>
            </tr>
        </tbody>
    @endif
</table>