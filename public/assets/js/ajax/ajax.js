/*
* Prerequesites
* @var url
*/

// Add New Record
$('form.ajax').on('submit', function(e){
    e.preventDefault();
    var Form = $(this);
    $.ajax({
        url: Form.attr('action'),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData:false,
        beforeSend: function(){
            Form.find('[type=submit]').attr("disabled", true);
            Form.find("[type='submit']").prepend('<i class="fa fa-spinner fa-spin"></i> ');
        },
        success: function(data){
            toastr.success(data);
            if(Form.hasClass('should-reset'))
                Form.trigger('reset');
            if (data.redirect)
                window.location.href = data.redirect;
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
            Form.find('[type=submit]').attr("disabled", false);
            Form.find(".fa-spin").remove();
        }
    });
});


// Delete A Record
$(document).on("click", '.delete',function(e){
    e.preventDefault();
    Swal.fire({
        title: 'هل أنت متأكد ؟',
        text: "سيتم حذف العنصر!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        cancelButtonText: 'تراجع',
        confirmButtonText: 'حذف!'
    }).then((result) => {
        if (result.value) {
            var btn = $(this);
            $.ajax({
                url: btn.attr('href'),
                type: 'DELETE',
                data: [],
                beforeSend: function(){
                    btn.addClass('disabled');
                    btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
                    $('.error').remove();
                },
                success: function(data){
                    var row = btn.parents('.deletable');
                    row.fadeOut(300, function(){
                        row.remove();
                    });
                    Swal.fire('تم الحذف!', data, 'success');
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
                        errMsg += errors.message;
                    } else {
                        errMsg += errors;
                    }
                    Swal.fire('خطأ!', errMsg, 'error');
                },
                complete: function (data){
                    btn.removeClass('disabled');
                    btn.find(".fa-spin").remove();
                }
            });
        }
    });
});