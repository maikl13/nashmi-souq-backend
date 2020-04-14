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
            if (Form.hasClass('swal-msg')){
                Swal.fire('', data, 'success');
            } else {
                toastr.success(data);
            }
            if(Form.hasClass('should-reset'))
                Form.trigger('reset');
            if (data.redirect)
                window.location.href = data.redirect;
            if(Form.data('on-success'))
                executeFunctionByName(Form.data('on-success'), window);
        },
        error: function(data){
            var errMsg = get_error_msg(data);
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
                    var errMsg = get_error_msg(data);
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

function executeFunctionByName(functionName, context /*, args */) {
  var args = Array.prototype.slice.call(arguments, 2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for(var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(context, args);
}