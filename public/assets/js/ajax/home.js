var page = 2,
    btn = $('.more-listings'),
    btnText = btn.text();
$(document).on("click", '.more-listings', function(e){
    e.preventDefault();
    $.get({
        url: '/?page='+page,
        beforeSend: function(){
            $(this).attr("disabled", true);
            $(this).html('<i class="fa fa-spinner fa-spin" style="padding: 2px 0px;"></i>');
        },
        success: function(data){
            console.log(data);
            if(!data) btn.hide();
            $('.listings').append(data);
        },
        error: function(data){
            var errMsg = get_error_msg(data);
            Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            page++;
            $(this).attr("disabled", false).text( btnText );;
        }
    });
});