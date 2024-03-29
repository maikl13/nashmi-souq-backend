
$(document).ready(function(){
    $(":radio.labelauty").labelauty();
});
$(document).on('click', '.promote', function(){
    $('#promote-form input[name=listing_id]').val( $(this).data('listing-id') );
    $('#promote-form input[name=listing_id]').val( $(this).data('listing-id') );
});
$(document).on('click', '.promote2', function(){
    $('#promote-form2 input[name=listing_id]').val( $(this).data('listing-id') );
    $('#promote-form2 input[name=listing_id]').val( $(this).data('listing-id') );
});
$(document).on('click', '.promote-btn', function(){
    var balance = $('.current-balance').text();
    var price = $('#promote-form input[name=tier]:checked').data('price');
    var currency = $('#promote-form input[name=tier]:checked').data('currency');
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
            html: "سيتم ترقية الإعلان لإعلان مميز و خصم <strong>"+price+" "+currency+"</strong> من محفظتك!",
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

$(document).on('click', '.promote-btn2', function(){
    var balance = $('.current-balance').text();
    var price = $('#promote-form2 input[name=tier]:checked').data('price');
    var currency = $('#promote-form2 input[name=tier]:checked').data('currency');
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
            html: "سيتم ترقية الإعلان لإعلان مميز و خصم <strong>"+price+" "+currency+"</strong> من محفظتك!",
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#f85c70',
            cancelButtonText: 'تراجع',
            confirmButtonText: 'موافق!'
        }).then((result) => {
            if (result.value) {
               $('#promote-form2').submit();
               $('#promote2').modal('hide');
            }
        });
    }
});

function remove_promote_button(){
    var id = $('#promote-form input[name=listing_id]').val();
    var price = $('#promote-form input[name=tier]:checked').data('price'),
        newCurrentBalance = $('.current-balance').first().text() - price,
        newExpensedBalance = parseFloat($('.expensed-balance').first().text())+0 + price;
    newCurrentBalance = (newCurrentBalance).toFixed(4);
    newExpensedBalance = (newExpensedBalance).toFixed(4);
        
    $('.current-balance').text( newCurrentBalance );
    $('.payout-balance').text( newCurrentBalance );
    $('.expensed-balance').text( newExpensedBalance );
    $('a.promote[data-listing-id='+id+']').parents('.listing-box').addClass('item-trending');
    $('a.promote[data-listing-id='+id+']').remove();
}

function remove_promote_button2(){
    var id = $('#promote-form2 input[name=listing_id]').val();
    var price = $('#promote-form2 input[name=tier]:checked').data('price'),
        newCurrentBalance = $('.current-balance').first().text() - price,
        newExpensedBalance = parseFloat($('.expensed-balance').first().text())+0 + price;
    newCurrentBalance = (newCurrentBalance).toFixed(4);
    newExpensedBalance = (newExpensedBalance).toFixed(4);
        
    $('.current-balance').text( newCurrentBalance );
    $('.payout-balance').text( newCurrentBalance );
    $('.expensed-balance').text( newExpensedBalance );
    $('a.promote2[data-listing-id='+id+']').parents('.listing-box').addClass('item-fixed');
    $('a.promote2[data-listing-id='+id+']').remove();
}