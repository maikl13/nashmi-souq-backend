<div class="form-group">
    <label for="product_title" class="form-control-label"> الاسم :</label>
    <input type="text" class="form-control text-right" id="product_title" name="product_title" value="{{ old('product_title') }}" required>
</div>

<div class="form-group">
    <label for="description" class="form-control-label"> وصف المنتج :</label>
    <textarea name="description" class="form-control textarea" id="description" cols="30" rows="8" required>{!! old('description') !!}</textarea>
</div>

@php($categories = App\Models\Category::whereNull('category_id')->whereIn('id', auth()->user()->store_categories)->get())
<div class="form-group {{ $categories->count() == 1 ? 'd-none' : '' }}">
    <label for="category" class="form-control-label"> القسم الرئيسي :</label>
    <select name="category" class="category-select categories-select2 form-control @error('category') is-invalid @enderror" required>
        <option value="">- قم باختيار القسم التابع له المنتج</option>
        @foreach( $categories as $category )
            <option value="{{ $category->slug }}" {{ old('category') == $category->slug || $categories->count() == 1 ? 'selected' : '' }}>{{ $category->name }}</option>
        @endforeach
    </select>
</div>
@if( old('category') )
    <?php 
        $category = App\Models\Category::where( 'slug', old('category') )->first(); 
        $sub_categories_count = 0;
        if($category) $sub_categories_count = $category->children()->count();
    ?>
@elseif( $categories->count() == 1 )
    <?php 
        $category = $categories->first(); 
        $sub_categories_count = 0;
        if($category) $sub_categories_count = $category->children()->count()
    ?>
@endif
<div class="form-group">
    <label for="product_title" class="form-control-label"> القسم الفرعي :</label>
    <select name="sub_category" class="sub-category-select sub-categories-select2 form-control @error('sub_category') is-invalid @enderror" {{ isset($sub_categories_count) && $sub_categories_count ? '' : 'disabled' }}>
        <option value="">- إختر القسم الفرعي</option>
        @if ( isset($sub_categories_count) && $sub_categories_count )
            @foreach ($category->all_children() as $sub_category)
                <?php 
                    $prefix = '';
                    for ($i=2; $i < $sub_category->level(); $i++) { $prefix .= '___'; }
                ?>
                <option value="{{ $sub_category->slug }}" {{ old('sub_category') == $sub_category->slug ? 'selected' : '' }}>{{ $sub_category->name }}</option>
            @endforeach
        @endif
    </select>
</div>