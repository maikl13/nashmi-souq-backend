$(document).on('click', '.add-to-cart', function(e){
    e.preventDefault();
    var productId = $(this).data('product-id');
    add_to_cart(productId, 1);
});

$(document).on('click', '.remove-from-cart', function(e){
    e.preventDefault();
    var productId = $(this).data('product-id');
    remove_from_cart(productId);
});

$(document).on('submit', '.cart-form', function(e){
    e.preventDefault();
    var productId = $(this).find('.product-id').val(),
        quantity = $(this).find('.quantity').val();
    add_to_cart(productId, quantity);
});

$(document).on('change', '.quantity', function(e){
    e.preventDefault();
    var productId = $(this).parents('tr').data('product-id'),
        quantity = $(this).val()
        row = $(this).parents('tr');
    row.html('<td colspan="4" class="px-2 py-4 text-center" style="font-size: 16px"><i class="fa fa-circle-o-notch fa-spin text-muted"></i> <small>جاري التحديث</small></td>')
    update_product_quantity(productId, quantity);
});

function add_to_cart(productId, quantity){
    $.ajax({
        url: '/cart/add',
        type: 'POST',
        data: {
            'product_id': productId,
            'quantity': quantity
        },
        success: function(data){
            update_cart_dropdown();
            redirect_to_cart();
        }
    });
}

function update_cart_dropdown(openDropdown=false){
    $.ajax({
        url: '/cart/update-dropdown',
        type: 'GET',
        success: function(data){
            $('.cart-dropdown').html(data);
            if(openDropdown)
                $('.cart-dropdown .dropdown-toggle').dropdown('toggle');
        }
    });
}

function remove_from_cart(productId){
    $.ajax({
        url: '/cart/'+ productId +'/remove',
        type: 'DELETE',
        success: function(data){
            update_cart_dropdown(true);
            var row = $('tr[data-product-id='+ productId +']');
            if( row.length ) row.remove();
            update_totals();
        }
    });
}

function update_product_quantity(productId, quantity){
    $.ajax({
        url: '/cart/update-quantity',
        type: 'POST',
        data: {
            'product_id': productId,
            'quantity': quantity
        },
        success: function(data){
            var row = $('tr[data-product-id='+ productId +']');
            row.before(data);
            row.remove();
            $("input[name='demo_vertical2']").TouchSpin({verticalbuttons:!0,verticalupclass:"fa fa-plus",verticaldownclass:"fa fa-minus"});
            $('tr[data-product-id='+ productId +'] input[name="demo_vertical2"]').focus();
            update_totals();
            update_cart_dropdown();
        }
    });
}

function update_totals(){
    var totals = $('.totals');
    if( totals.length ){
        totals.html('<div class="px-2 py-4 text-center" style="font-size: 16px"><i class="fa fa-circle-o-notch fa-spin text-muted"></i> <small>جاري التحديث</small></div>')
        $.ajax({
            url: '/cart/update-totals',
            type: 'GET',
            success: function(data){
                var totals = $('.totals');
                totals.before(data);
                totals.remove();
            }
        });
    }
}


function redirect_to_cart() {
    Swal.fire({
      title: "تم اضافة المنتج لعربة التسوق",
      width: 720,
      padding: '3em',
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: "إتمام الطلب الآن",
      showCancelButton: true,
      cancelButtonText: "متابعة التسوق!"
    }).then((result) => {
        if (result.value) {
            window.location.href = "/cart";
        }
    })
}