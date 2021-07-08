<?php $product = App\Models\Product::find($id); ?>

@if ($product)
    @php
        $option_values = App\Models\OptionValue::whereIn('id', optional($product->options)['values'] ?? [])->get();
    @endphp

    @foreach ($option_values as $option_value)
        {{ $option_value->option->name }}: {{ $option_value->name }} <br>
    @endforeach
@endif
    