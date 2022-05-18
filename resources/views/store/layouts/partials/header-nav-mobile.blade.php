<nav class="d-flex d-lg-none align-items-center p-1 position-fixed" dir="ltr" 
    style="column-gap: 10px; top: 0; z-index: 30;left: 62px;height: 75px;">

    
    <a class="text-secondary px-3 py-2 bg-light rounded-lg d-lg-none toggle-cart text-center" style="font-size: 18px;">
        <img width="20" height="20" src="/assets/images/cart.svg" class="loaded">
        <span class="cartQty" style="font-size: 14px; position: absolute; top: 6px; text-shadow: 0 0 5px white; left: 25px; font-weight: bold;">{{ cart()->total_quantity() ? cart()->total_quantity() : '' }}</span>
    </a>
    
    {{-- <a href="" class="text-secondary px-3 py-2">

    </a> --}}

</nav>
