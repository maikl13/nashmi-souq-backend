(function() {

  $('.toggle-chat').on('click', function(e) {
    e.preventDefault();
    $('.chat').slideToggle(300, 'swing');
    $('.chat-message-counter').fadeToggle(300, 'swing');
        $(".chat-history").animate({ scrollTop: 1000000 });
  });

  $('.chat-close').on('click', function(e) {
    e.preventDefault();
    $('#live-chat').fadeOut(300);
  });

    $("#chat-message").keypress(function (e) {
        if(e.keyCode === 13 && !e.shiftKey) {
            e.preventDefault();
            $('.chat-form').submit();
        }
    });

    var textarea = document.getElementById('chat-message');
  textarea.addEventListener('keydown', autosize);
  function autosize(){
    var el = this;
    setTimeout(function(){
      el.style.cssText = 'height:auto; padding:20px 0';
      // for box-sizing other than "content-box" use:
      // el.style.cssText = '-moz-box-sizing:content-box';
      el.style.cssText = 'height:' + el.scrollHeight + 'px';
    },0);
  }
}) ();




// AJAX
$('.guest-info-form').on('submit', function(e){
    e.preventDefault();
    var Form = $(this);
    $.ajax({
        url: '/guests/add',
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData:false,
        beforeSend: function(){
            Form.find('.error').hide();
            Form.find('button[type=submit]').attr("disabled", true);
            Form.find("button[type='submit']").prepend('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(data){
            Form.hide();
            $('.chat-box').fadeIn();
            $('meta[name=uid]').attr('content', data['uid']);
            $('meta[name=conversation_id]').attr('content', data['conversation_id']);
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
            Form.find('.error').show();
            Form.find('.error').html( errMsg );
            // Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            Form.find('button[type=submit]').attr("disabled", false);
            Form.find(".fa-spin").remove();
        }
    });
});



$('.chat-form').on('submit', function(e){
    e.preventDefault();
    var Form = $(this),
        messageBox = $('.chat-history');
    $.ajax({
        url: '/messages/add',
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData:false,
        beforeSend: function(){
            Form.find('.error').hide();
            Form.find('button[type=submit]').attr("disabled", true);
            Form.find("button[type='submit']").prepend('<i class="fa fa-spinner fa-spin"></i>');
        },
        success: function(data){
            Form.trigger('reset');
            messageBox.html(data['message']);
            if( !$('meta[name=conversation_id]').attr('content') ) {
                $('meta[name=conversation_id]').attr('content', data['conversation_id']);
                open_channel(data['conversation_id']);
            }
            $(".chat-history").animate({ scrollTop: 1000000 });
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
            Form.find('.error').show();
            Form.find('.error').html( errMsg );
            // Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            Form.find('button[type=submit]').attr("disabled", false);
            Form.find(".fa-spin").remove();
        }
    });
});


function get_conversation(){
    var messageBox = $('.chat-history');
    $.ajax({
        url: '/conversation',
        type: 'GET',
        beforeSend: function(){
            $('.error').hide();
            var spinner = '<div class="text-center" style="padding: 200px 15px; font-size: 40px">'+
                            '<i class="fa fa-spinner fa-spin" style="opacity:.7"></i>'+
                        '</div>';
            messageBox.html(spinner);
        },
        success: function(data){
            messageBox.html(data);
            $(".chat-history").animate({ scrollTop: 1000000 });
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
            messageBox.find('.fa-spin').remove();
            $('.chat-form .error').html( errMsg );
        },
        complete: function (data){
            $('.contacts-list .fa-spin').remove();
        }
    });
}


$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
function open_channel(id){
    window.Echo.channel('messages.'+ id)
    .listen('MessageSent', (e) => {
        console.log('get-conversation');
        get_conversation();
    });
}
$(document).ready(function(){
    var id = $('meta[name=conversation_id]').attr('content');
    open_channel(id);
});

$(document).on('click', '.dropdown-menu', function (e) {
  e.stopPropagation();
});