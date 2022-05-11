<nav class="d-flex d-lg-none align-items-center p-1 position-fixed" dir="ltr" 
    style="column-gap: 10px; top: 0; z-index: 30;left: 62px;height: 75px;">
    @php
        $path = str_replace(url('/'), '', url()->current());
    @endphp
        
    @if ($path != '/listings')
        <a href="#" class="text-secondary px-3 py-2 bg-light rounded-lg toggle-search">
            <i class="fa fa-search"></i>
        </a>
    @endif
    
    {{-- <a href="" class="text-secondary px-3 py-2">

    </a> --}}

</nav>
