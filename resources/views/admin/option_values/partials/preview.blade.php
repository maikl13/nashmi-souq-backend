@php
	$option_value = App\Models\OptionValue::find($id);
	$content = $option_value->name;
	$bgColor = '#fafafa';
	$border_radius = '15px';
	$classes = 'px-3 py-1';
	$styles= '';

	if($option_value->preview_config == App\Models\Option::PREVIEW_NONE){
		$content = '';
		$border_radius = '30px';
		$classes = 'border small p-2';
		$styles = 'min-width: 28px;min-height: 28px;';
	}
	elseif($option_value->preview_config == App\Models\Option::PREVIEW_HTML){
		$content = $option_value->html;
	}
	elseif($option_value->preview_config == App\Models\Option::PREVIEW_FIXED_IMAGE){
		if ($option_value->image) {
			$content = '<img src="'.$option_value->option_value_image(['size'=>'s']).'" alt="Option Image">';
			$border_radius = '7px';
			$classes = 'mb-1';
			$bgColor = 'transparent';
		}
	}
	elseif($option_value->preview_config == App\Models\Option::PREVIEW_PRODUCT_IMAGE){
		$content = 'صورة المنتج';
		if ($image = ($option_value_product_image ?? null)) {
			$content = '<img width="96" src="'.$image.'" alt="Product Image">';
			$border_radius = '7px';
			$classes = 'mb-1 mx-2';
			$bgColor = 'transparent';
		}
	}

	if($option_value->color_config == App\Models\Option::COLOR_CUSTOM){
		$bgColor = $option_value->color ?? '#fafafa';
	}
@endphp

<span data-toggle="tooltip" title="{{ $option_value->name }}" class="{{ $classes }}" style="border-radius: {{ $border_radius }};display: inline-flex;background: {{ $bgColor }}; {{ $styles }}">{!! $content !!}</span>

<script>
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
</script>