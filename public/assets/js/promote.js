
$(document).ready(function(){
    $(":radio.labelauty").labelauty();
});
$(document).on('click', '.promote', function(){
    $('#promote-form input[name=listing_id]').val( $(this).data('listing-id') );
    $('#promote-form input[name=listing_id]').val( $(this).data('listing-id') );
});
$(document).on('click', '.promote-btn', function(){
    var balance = $('.current-balance').text();
    var price = $('input[name=tier]:checked').data('price');
    if(balance < price){
        Swal.fire({
            title: 'عفوا!',
            html: "رصيدك الحالي لا يكفي لإتمام العملية!",
            type: 'error',
            showCancelButton: true,
            confirmButtonColor: '#f85c70',
            cancelButtonText: 'تراجع',
            confirmButtonText: 'شحن رصيد الحساب!'
        }).then((result) => {
            if (result.value) {
                window.location.href = '/balance';
            }
        });
    } else {
        Swal.fire({
            title: 'هل أنت متأكد ؟',
            html: "سيتم ترقية الإعلان لإعلان مميز و خصم <strong>"+price+"$</strong> من محفظتك!",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f85c70',
            cancelButtonText: 'تراجع',
            confirmButtonText: 'موافق!'
        }).then((result) => {
            if (result.value) {
               $('#promote-form').submit();
               $('#promote').modal('hide');
            }
        });
    }
});

function remove_promote_button(){
    var id = $('#promote-form input[name=listing_id]').val();
    var price = $('input[name=tier]:checked').data('price'),
        newPrice = $('.current-balance').text() - price;
    $('.current-balance').text( newPrice );
    $('a.promote[data-listing-id='+id+']').parents('.listing-box').addClass('item-trending');
    $('a.promote[data-listing-id='+id+']').remove();
}