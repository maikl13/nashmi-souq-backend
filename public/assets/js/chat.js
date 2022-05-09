(function() {
    $(document).on('click', '.toggle-chat', function(e) {
        e.preventDefault();

        $(this).removeClass('unseen');
        $('[name=listing_id]').val( $(this).data('listing') );

        // if it's the first time to open the chatbox for that user
        if($('#live-chat').attr('data-recipient') != $(this).data('username')){
            $('.chat').slideDown(300)
            $(".chat-history").animate({ scrollTop: 1000000 });
            $('.chat').addClass('shown')

            $('.recipient-name').text( $(this).data('name') );
            $('.recipient-username').val( $(this).data('username') );
            $('.recipient-logo').attr('src', $(this).data('logo') );
            $('#live-chat').attr('data-recipient', $(this).data('username') );

            get_conversation( $(this).data('username') );
        } else {
            if($('.chat').hasClass('shown')){
                $('.chat').removeClass('shown')
                $('.chat').slideUp(300, 'swing');
            } else {
                $('.chat').slideDown(300)
                $('.chat').addClass('shown')
            }
        }
    });

    $('.chat-box-header').on('click', function(e) {
        $('.chat').removeClass('shown').slideToggle(300, 'swing');
    });

    var isMobile = false; //initiate as false
    // device detection
    if(/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|ipad|iris|kindle|Android|Silk|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i.test(navigator.userAgent) 
        || /1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i.test(navigator.userAgent.substr(0,4))) { 
        isMobile = true;
    }

    $("#chat-message").keypress(function (e) {
        if(e.keyCode === 13 && !e.shiftKey && !isMobile) {
            e.preventDefault();
            $('.chat-form').find('[type=submit]').click();
        }
    });

    var textarea = document.getElementById('chat-message');
    textarea.addEventListener('keydown', autosize);
    function autosize(){
        var el = this;
        setTimeout(function(){
            el.style.cssText = 'height:auto; padding:20px 0';
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
            messageBox.html(data);
            $(".chat-history").animate({ scrollTop: 1000000 });
            get_conversations();
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
            update_unseen_messages_counter();
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
        console.log('You\'v got a new message from'+e.sender_username);
        if($('#live-chat').data('recipient') == e.sender_username){
            get_conversation(e.sender_username);
        } else {
            update_unseen_messages_counter();
        }
        get_conversations();
    });
}

$(document).ready(function(){
    var username = $('meta[name=username]').attr('content');
    open_channel(username);
});

$(document).on('click', '.dropdown-menu', function (e) {
    e.stopPropagation();
});

$(document).ready(function () {
    $(document).click(function (e) {
        var clickover = $(e.target);
        if (
            !clickover.is(".toggle-conversations *") && !clickover.is(".toggle-conversations")
            // && !clickover.is(".conversations-dropdown *") && !clickover.is(".conversations-dropdown")
        ) {
            $('.conversations-dropdown').hide();
        } else if (!clickover.is(".conversations-dropdown *") && !clickover.is(".conversations-dropdown")) {
            e.preventDefault();
            $('.conversations-dropdown').toggle();
            if(!$('.conversations-dropdown').hasClass('loaded')){
                get_conversations();
            }
        }
    });
});



function get_conversations(){
    $.ajax({
        url: '/conversations',
        type: 'GET',
        success: function(data){
            $('.conversations-box').html(data);
            $('.conversations-dropdown').addClass('loaded');
        },
        error: function(data){
            var errMsg = get_error_msg(data);
            Swal.fire('خطأ!', errMsg, 'error');
            $('.conversations-box').html('<div class="text-center preloader py-5"><i class="fa fa-times"></i><span style="font-size: 15px;">'+
                                '<br>حدث خطأ ما! قم بتحديث الصفحة و المحاولة مجددا<span></div>');
        }
    });
}

function update_unseen_messages_counter() {
    $.ajax({
        url: '/messages/unseen',
        type: 'GET',
        success: function(data){
            $('.unread').text(data);
            if(data != 0){ $('.unread').show(); } else { $('.unread').hide(); }
        },
        error: function(data){
            $('.unread').hide();
        }
    });
}
