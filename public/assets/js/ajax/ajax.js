/*
* Prerequesites
* @var url
*/

// Add New Record
$(document).on('submit', 'form.ajax', function(e){
    e.preventDefault();
    var Form = $(this);
    $.ajax({
        url: Form.attr('action'),
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData:false,
        xhr: function() {
            var xhr = new window.XMLHttpRequest();
            xhr.upload.addEventListener("progress", function(evt) {
                progress = Form.find(".progress");
                progress.removeClass('d-none');
                if (evt.lengthComputable) {
                    var percentComplete = ((evt.loaded / evt.total) * 100);
                    Form.find(".progress-bar").width(percentComplete + '%');

                    if(percentComplete == 100){
                        progress.addClass('d-none');
                        $('<i class="fa fa-spinner fa-spin"></i> <i>برجاء الانتظار<i/>').insertBefore(progress);
                    }
                }
            }, false);
            return xhr;
        },
        beforeSend: function(){
            if(Form.data('before-send'))
                executeFunctionByName(Form.data('before-send'), window);
            Form.find('[type=submit]').attr("disabled", true);
            if (!Form.hasClass('no-spinner')){
                Form.find("[type='submit']").prepend('<i class="fa fa-spinner fa-spin"></i> ');
            }
        },
        success: function(data){
            if (Form.hasClass('no-msg')){
                // do nothing
            } else if (Form.hasClass('swal-msg')){
                Swal.fire('', data, 'success');
            } else {
                var msg = "تم الحفظ بنجاح";
                if(typeof data == 'string') msg = data;
                toastr.success(msg);
            }
            if(Form.data('on-success'))
                executeFunctionByName(Form.data('on-success'), window, data);
            if(Form.hasClass('should-reset'))
                Form.trigger('reset');
            if (data.redirect)
                window.location.href = data.redirect;
        },
        error: function(data){
            var errMsg = get_error_msg(data);
            Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            if(Form.data('on-complete'))
                executeFunctionByName(Form.data('on-complete'), window, data);
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
                    var row = btn.parents('.deletable').first();
                    row.fadeOut(300, function(){
                        row.remove();
                    });
                    if (btn.hasClass('no-msg')){
                        // do nothing
                    } else {
                        Swal.fire('تم الحذف!', data, 'success');
                    }
                    
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

function executeFunctionByName(functionName, context , args='') {
  var args = Array.prototype.slice.call(arguments, 2);
  var namespaces = functionName.split(".");
  var func = namespaces.pop();
  for(var i = 0; i < namespaces.length; i++) {
    context = context[namespaces[i]];
  }
  return context[func].apply(context, args);
}