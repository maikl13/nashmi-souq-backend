<script>
    $(document).on('click', '.state-id', function(e){
        e.preventDefault();
        $("input[name='states[]']").val( $(this).data('id') );
        $('#modal-location').modal('hide');
        $('.location-label').text( $(this).text() );
    });
    $(document).on('click', '.category-id', function(e){
        e.preventDefault();
        $("input[name='categories[]']").val( $(this).data('id') );
        $('#modal-category').modal('hide');
        $('.category-label').text( $(this).text() );
    });
</script>