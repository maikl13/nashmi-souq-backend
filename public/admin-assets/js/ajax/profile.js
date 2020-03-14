// edit Profile
$('.edit').on('submit', function(e){
	e.preventDefault();
    var Form = $(this),
        url = '/admin/profile/edit';
    if( Form.hasClass('change-password') ){
        url = '/admin/profile/change-password';
    }
    $.ajax({
		url: url,
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData:false,
        beforeSend: function(){
            Form.find('button[type=submit]').attr("disabled", true);
            Form.find("button[type='submit']").prepend('<i class="fa fa-spinner fa-spin"></i> ');
        },
        success: function(data){
            toastr.success('تم حفظ البيانات بنجاح' );
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
            Form.find(".fa-spin").remove();
        }
    });
});