@if ($options)
    <option value="">- إختر صفة</option>
    @foreach ($options as $option)
        <option value="{{ $option->id }}">{{ $option->name }}</option>
    @endforeach
@endif