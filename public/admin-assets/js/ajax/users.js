$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

// $(document).on("click", '.delete',function(e){
// 	e.preventDefault();
// 	Swal.fire({
//       	title: 'هل أنت متأكد?',
//      	text: "سيتم حذف العنصر!",
//       	type: 'warning',
//       	showCancelButton: true,
//       	confirmButtonColor: '#3085d6',
//       	cancelButtonColor: '#d33',
//       	cancelButtonText: 'تراجع',
//       	confirmButtonText: 'حذف!'
//     }).then((result) => {
//     	if (result.value) {
//             var btn = $(this),
//                 id = btn.data('id');
//     	  	// $(this).parent('form').submit();
//     	  	$.ajax({
//                 url: '/admin/users/'+id+'/delete',
//                 type: 'DELETE',
//                 data: [],
//                 beforeSend: function(){
//                     btn.addClass('disabled');
//                     btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
//                     $('.error').remove();
//                 },
//                 success: function(data){
//                     btn.parent().parent().remove();
//                 	Swal.fire('تم الحذف!', data, 'success');
//                 },
//                 error: function(data){
//                     var errMsg = '';
//                     var errors = data.responseJSON;
//                     if(data.responseJSON.errors){
//                         errors = data.responseJSON.errors;
//                         $.each(errors , function( key, value ) {
//                             errMsg += value[0] + '</br>';
//                         });
//                     } else if(errors.message) {
//                         errMsg += errors.message;
//                     } else {
//                         errMsg += errors;
//                     }
//                 	Swal.fire('خطأ!', errMsg);
//                 },
//                 complete: function (data){
//                     btn.removeClass('disabled');
//                     btn.find(".fa-spin").remove();
//                 }
//             });
//     	}
//     });
// });

$(document).on("click", '.toggle-active-state',function(e){
	e.preventDefault();
	Swal.fire({
      	title: 'هل أنت متأكد ?',
     	text: "سيتم تغيير حالة العضو!",
      	type: 'warning',
      	showCancelButton: true,
      	confirmButtonColor: '#3085d6',
      	cancelButtonColor: '#d33',
      	cancelButtonText: 'تراجع',
      	confirmButtonText: 'نعم!'
    }).then((result) => {
        if (result.value) {
            var btn = $(this),
                id = btn.data('id');
            $.ajax({
                url: '/admin/users/'+id+'/active/toggle',
                type: 'POST',
                data: [],
                beforeSend: function(){
                    btn.addClass('disabled');
                    btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
                    $('.error').remove();
                },
                success: function(data){
                    btn.toggleClass('btn-warning');
                    btn.toggleClass('btn-primary');
                    btn.find('i.fa').toggleClass('fa-check');
                    btn.find('i.fa').toggleClass('fa-close');
            		toastr.success('تم التحديث بنجاح' );
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
                	Swal.fire('خطأ!', errMsg);
                },
                complete: function (data){
                    btn.removeClass('disabled');
                    btn.find(".fa-spin").remove();
                }
            });
        }
    });
});

$(document).on("change", '.filter',function(e){
	var role_id;
	if($(this).val() == 0){
		role_id = '';
	} else {
		role_id = $(this).val();
	}
	window.LaravelDataTables["data-table"].column(4).search( role_id ).draw()
});










$(document).on("click", '.change-role',function(e){
	e.preventDefault();
        var id = $(this).parent().data('id'),
        	role = $(this).data('role');
	Swal.fire({
      	title: 'هل أنت متأكد ?',
     	text: "سيتم تغيير صلاحيات العضو!",
      	type: 'warning',
      	showCancelButton: true,
      	confirmButtonColor: '#3085d6',
      	cancelButtonColor: '#d33',
      	cancelButtonText: 'تراجع',
      	confirmButtonText: 'نعم!'
    }).then((result) => {
        if (result.value) {
            var btn = $(this);
            $.ajax({
                url: '/admin/users/'+id+'/change-role',
                type: 'POST',
                data: {role: role},
                beforeSend: function(){
                    btn.addClass('disabled');
                    btn.prepend('<i class="fa fa-spinner fa-spin"></i> ');
                    $('.error').remove();
                },
                success: function(data){
                    btn.parents('tr').find('.role').text(data);
            		toastr.success('تم التحديث بنجاح' );
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
                	Swal.fire('خطأ!', errMsg);
                },
                complete: function (data){
                    btn.removeClass('disabled');
                    btn.find(".fa-spin").remove();
                }
            });
        }
    });
});