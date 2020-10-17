function appendComment(data){
    $('.comments').prepend(data);
}

$(document).on("click", '.edit-comment', function(e){
    e.preventDefault();
    var commentId = $(this).data('comment-id');
    var comment = $('#comment-'+commentId).find('.comment-text').first().html();
    $('#edit-comment-modal').modal('show');
    $('#edit-comment-modal').find('.comment-body').html(comment);
    $('#edit-comment-modal').find('.comment-id').val(commentId);
});

function updateComment(data){
    var commentId = $('#edit-comment-modal').find('.comment-id').val();
    $('#comment-'+commentId).find('.comment-text').first().html(data);
    $('#edit-comment-modal').modal('hide');
}


