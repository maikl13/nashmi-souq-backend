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

var isMobile = false; //initiate as false
// device detection
if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
    || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
    isMobile = true;
}

$("[name=comment]").keypress(function (e) {
    if(e.keyCode === 13 && !e.shiftKey && !isMobile) {
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


