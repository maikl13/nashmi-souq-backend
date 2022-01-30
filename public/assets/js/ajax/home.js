var page = (new URL(window.location.href)).searchParams.get("page"),
    btn = $('.more-listings'),
    btnText = btn.text();

page = page ? page++ : 2;

$(document).on("click", '.more-listings', function(e){
    e.preventDefault();
    $.get({
        url: '/?json=1&page='+page,
        beforeSend: function(){
            btn.attr("disabled", true);
            btn.html('<i class="fa fa-spinner fa-spin" style="padding: 2px 0px;"></i> ' + btnText);
        },
        success: function(data){
            window.history.replaceState(null, '', '?page='+page);
            if(!data) btn.hide();
            $('.listings').append(data);
        },
        error: function(data){
            var errMsg = get_error_msg(data);
            Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            page++;
            btn.attr("disabled", false).text( btnText );;
        }
    });
});