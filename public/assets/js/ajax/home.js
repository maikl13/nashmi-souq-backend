var page = (new URL(window.location.href)).searchParams.get("page"),
    btn = $('.more-listings'),
    loading = false,
    noMoreResults = false;

page = page ? page++ : 2;

$(document).on("click", '.more-listings', function(e){
    e.preventDefault();
    loadMoreListings();
});

$(window).scroll(function() {
    var hT = $('.listings').offset().top,
        hH = $('.listings').outerHeight(),
        wH = $(window).height(),
        wS = $(this).scrollTop();


    if (wS > (hT + hH - wH)) {
        if(!loading && $(window).width() < 992){
            loading = true;
            loadMoreListings();
        }
    }
});

function loadMoreListings() {
    if (noMoreResults) return;
    // if(page>2) noMoreResults = true;
    
    $.get({
        url: '/?_ajax=1&page='+page,
        beforeSend: function(){
            btn.attr("disabled", true);
            btn.find('.fa-spinner').remove();
            btn.prepend('<i class="fa fa-spinner fa-spin" style="padding: 2px 0px;"></i>');
        },
        success: function(data){
            window.history.replaceState({}, '', '?page='+page);
            // window.history.pushState({}, '', '?page='+page);

            if(!data){
                btn.hide();
                noMoreResults = true;
            } else {
                $('.listings').append(data);
            }
        },
        error: function(data){
            var errMsg = get_error_msg(data);
            Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            page++;
            btn.find('.fa-spinner').remove();
            btn.attr("disabled", false);
            loading = false;
        }
    });
}
