<select name="brand[]" class="brand-select form-control">
    <option value="">-</option>
    @foreach ($brands as $brand)
        <option value="{{ $brand->slug }}" 
            {{ isset($listing) && $listing->brand_id == $brand->id ? 'selcted' : '' }}
            {{ isset($listing) && $listing->brand && optional($listing->brand->parent)->id == $brand->id ? 'selcted' : '' }}>{{ $brand->name }}</option>    
    @endforeach
</select>