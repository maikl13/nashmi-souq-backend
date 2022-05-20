<script>
    $(() => { update_fields(); });
    
    $(document).on('change', '[name=preview_config]', function(){
        update_fields();
    });

    $(document).on('change', '[name=color_config]', function(){
        update_fields();
    });

    function update_fields(params) {
        if ($('[name=preview_config]').val() == {{ \App\Models\Option::PREVIEW_HTML }}) {
            $('[name=html]').parents('.form-group').show();
        } else {
            $('[name=html]').parents('.form-group').hide();
        }

        if ($('[name=preview_config]').val() == {{ \App\Models\Option::PREVIEW_FIXED_IMAGE }}) {
            $('#image-field').show();
        } else {
            $('#image-field').hide();
        }

        if ($('[name=color_config]').val() == {{ \App\Models\Option::COLOR_CUSTOM }}) {
            console.log('abc');
            $('[name=color]').parents('.form-group').show();
        } else {
            $('[name=color]').parents('.form-group').hide();
        }
    }
</script>
