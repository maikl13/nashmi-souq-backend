(function() {
    $('.toggle-chat').on('click', function(e) {
        e.preventDefault();
        $('.chat').slideToggle(300, 'swing');
        $(".chat-history").animate({ scrollTop: 1000000 });

        // if it's the first time to open the chatbox for that user
        if($('#live-chat').attr('data-recipient') != $(this).data('username')){
            $('.recipient-name').text( $(this).data('name') );
            $('.recipient-username').val( $(this).data('username') );
            $('.recipient-logo').attr('src', $(this).data('logo') );
            $('#live-chat').attr('data-recipient', $(this).data('username') );

            get_conversation( $(this).data('username') );
        }
    });

    $('.chat-box-header').on('click', function(e) {
        $('.chat').slideToggle(300, 'swing');
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
            el.style.cssText = 'height:auto; padding:15px 0';
            el.style.cssText = 'height:' + el.scrollHeight + 'px';
        },0);
    }
}) ();




$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

$('.chat-form').on('submit', function(e){
    e.preventDefault();
    var Form = $(this),
        messageBox = $('.chat-history'),
        btnText = Form.find("button[type='submit']").html();

    $.ajax({
        url: '/messages/add',
        type: 'POST',
        data: new FormData(this),
        contentType: false,
        processData:false,
        beforeSend: function(){
            Form.find('button[type=submit]').attr("disabled", true);
            Form.find("button[type='submit']").html('<i class="fa fa-spinner fa-spin" style="padding: 2px 0px;"></i>');
        },
        success: function(data){
            Form.trigger('reset');
            messageBox.html(data['message']);
            // if( !$('meta[name=conversation_id]').attr('content') ) {
                // $('meta[name=conversation_id]').attr('content', data['conversation_id']);
                // open_channel(data['conversation_id']);
            // }
            $(".chat-history").animate({ scrollTop: 1000000 });
        },
        error: function(data){
            var errMsg = get_error_msg(data);
            Swal.fire('خطأ!', errMsg, 'error');
        },
        complete: function (data){
            Form.find('button[type=submit]').attr("disabled", false);
            Form.find('button[type=submit]').html( btnText );
        }
    });
});


function get_conversation(username){
    var messageBox = $('.chat-history');
    $.ajax({
        url: '/conversation/' + username,
        type: 'GET',
        beforeSend: function(){
            messageBox.append('<div class="text-center preloader"><i class="fa fa-spinner fa-spin"></i></div>');
        },
        success: function(data){
            if(data.length) messageBox.html(data);
            $(".preloader").fadeOut();
            $(".chat-history").animate({ scrollTop: 1000000 });
        },
        error: function(data){
            var errMsg = get_error_msg(data);
            Swal.fire('خطأ!', errMsg, 'error');
            messageBox.html('<div class="text-center preloader"><i class="fa fa-times"></i><span style="font-size: 15px;">'+
                                '<br>حدث خطأ ما! قم بتحديث الصفحة و المحاولة مجددا<span></div>');
        }
    });
}


function open_channel(username){
    window.Echo.private('messages.'+ username)
    .listen('NewMessage', (e) => {
        console.log('You\'v got a new message :)');
        console.log(e.sender_username);
        if($('#live-chat').data('recipient') == e.sender_username){
            get_conversation(e.sender_username);
        }
    });
}

$(document).ready(function(){
    var username = $('meta[name=username]').attr('content');
    open_channel(username);
});

$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});