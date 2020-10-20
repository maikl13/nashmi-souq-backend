function appendComment(data){
    $('.comments .alert').remove();
    if(data.parent_id){
        $(data.comment).insertBefore('.comment[data-comment-id='+data.parent_id+'] .reply-form');
    } else {
        $('.comments').prepend(data.comment);
    }
}

function showLoading(data){
    $('.comment-form button i').addClass('fa-spinner fa-spin');
    $('.comment-form button i').removeClass('fa-comment');
}
function removeLoading(data){
    $('.comment-form button i').addClass('fa-comment');
    $('.comment-form button i').removeClass('fa-spinner fa-spin');
}

function showReplyLoading(data){
    $('.reply-form i').addClass('fa-spinner fa-spin');
    $('.reply-form i').removeClass('fa-angle-left');
    $('.reply-form i').parent().css('padding', '7px 11px');
}
function removeReplyLoading(data){
    $('.reply-form i').addClass('fa-angle-left');
    $('.reply-form i').removeClass('fa-spinner fa-spin');
    $('.reply-form i').parent().css('padding', '7px 16px');
}


$(document).on("click", '.edit-comment', function(e){
    e.preventDefault();
    var commentId = $(this).data('comment-id');
    var comment = $('#comment-'+commentId).find('.comment-text').first().html();
    $('#edit-comment-modal').modal('show');
    $('#edit-comment-modal').find('.comment-body').html(comment);
    $('#edit-comment-modal').find('.comment-id').val(commentId);
});


$("[name=comment]").keypress(function (e) {
    if(e.keyCode === 13 && !e.shiftKey) {
        e.preventDefault();
        $(this).parents('form').find('[type=submit]').click();
    }
});

function updateComment(data){
    var commentId = $('#edit-comment-modal').find('.comment-id').val();
    $('#comment-'+commentId).find('.comment-text').first().html(data);
    $('#edit-comment-modal').modal('hide');
}


$(document).on("click", '.reply-btn', function(e){
    e.preventDefault();
    var commentId = $(this).parents('.comment').data('comment-id');
    var replyForm = '<form action="/comments" method="post" class="reply-form ajax should-reset no-msg no-spinner" data-before-send="showReplyLoading" data-on-complete="removeReplyLoading"  data-on-success="appendComment" style="position: relative;">'+
        '<input name="comment" class="form-control mt-2 py-4" placeholder="اكتب ردك ..." style="border-radius: 25px;" required>'+
        '<input type="hidden" name="comment_id" value="'+commentId+'">'+
        '<button type="submit" class="btn btn-danger float-left" style="opacity: .7;position: absolute;bottom: 3px;left: 3px;padding: 7px 16px;border-radius: 50%;"><i class="fa fa-angle-left" style="font-size: 21px;line-height: 28px;"></i></button>'+
    '</form>';

    $('.reply-form').hide();
    
    if(!$(this).parents('.comment').find('.reply-form').length){
        $(this).parents('.comment').append(replyForm);
    } else {
        $(this).parents('.comment').find('.reply-form').show();
        placeInScreenCenter($(this).parents('.comment').find('.reply-form input'));
    }
    if(!onScreen($(this).parents('.comment').find('.reply-form input'))){
        placeInScreenCenter($(this).parents('.comment').find('.reply-form input'));
    }
    $(this).parents('.comment').find('.reply-form input').focus();
});

function placeInScreenCenter(el) {
    $([document.documentElement, document.body]).animate({
        scrollTop: el.offset().top - ($(window).height() / 2)
    }, 300);
}

function onScreen(el) {
    var top_of_element = el.offset().top;
    var bottom_of_element = el.offset().top + el.outerHeight();
    var bottom_of_screen = $(window).scrollTop() + $(window).innerHeight();
    var top_of_screen = $(window).scrollTop();

    if ((bottom_of_screen > top_of_element) && (top_of_screen < bottom_of_element)){
       return true;
    } else {
        return false;
    }
}


