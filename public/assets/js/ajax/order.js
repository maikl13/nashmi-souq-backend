$('.change-status-form').on('submit', function(e){
	e.preventDefault();
    var Form = $(this);
    Form.find(".overlay").show();
    $.ajax({
		url: '/orders/change-status',
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData:false,
        beforeSend: function(){
            Form.find('button[type=submit]').attr("disabled", true);
            Form.find("button[type='submit']").prepend('<i class="fa fa-spinner fa-spin"></i> ');
        },
        success: function(data){
            Form.trigger('reset');
            $('.change-status-options').html(data);
            $(":radio.labelauty").labelauty();
            $('#change-status-modal').modal('hide')
            toastr.success('تم الحفظ بنجاح' );
            update_status( $('[name=package_id]').val() );
            // update_shipping( $('[name=package_id]').val() );
            update_status_updates_log( $('[name=package_id]').val() );
        },
        error: function(data){
            var errMsg = '';
            var errors = data.responseJSON;
            if(data.responseJSON.errors){
                errors = data.responseJSON.errors;
                $.each(errors , function( key, value ) {
                    errMsg += value[0] + '</br>';
                });
            } else if(errors.message) {
                errMsg += "Error: " + errors.message;
            } else {
                errMsg += errors;
            }
            Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            Form.find('button[type=submit]').attr("disabled", false);
            Form.find(".overlay").hide();
            Form.find(".fa-spin").remove();
        }
    });
});

function update_shipping(packageId){
    $.ajax({
        url: '/orders/get-shipping',
        type: 'POST',
        data: { 'package_id': packageId },
        success: function(data){
            $('.order-shipping').text(data);
        }
    });
}
function update_status(packageId){
    $.ajax({
        url: '/orders/get-status',
        type: 'POST',
        data: { 'package_id': packageId },
        success: function(data){
            $('.order-status').text(data);
        }
    });
}
function update_status_updates_log(packageId){
    $.ajax({
        url: '/orders/get-status-updates-log',
        type: 'POST',
        data: { 'package_id': packageId },
        success: function(data){
            $('.order-status-updates-log').html(data);
        }
    });
}