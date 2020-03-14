(function($) {
	"use strict";

    if($(".editor").length > 0){
		// tinymce.init({
		// 	selector: "textarea.editor",
		// 	theme: "modern",
		// 	height:300,
		// 	plugins: [
				// "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				// "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				// "save table contextmenu directionality emoticons template paste textcolor"
		// 	],
			// toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons",
		// 	style_formats: [
		// 		{title: 'Bold text', inline: 'b'},
		// 		{title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
		// 		{title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
		// 		{title: 'Example 1', inline: 'span', classes: 'example1'},
		// 		{title: 'Example 2', inline: 'span', classes: 'example2'},
		// 		{title: 'Table styles'},
		// 		{title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
		// 	]
		// });


        /* TINYMCE WYSIWYG EDITOR */
        tinymce.init({
            selector: 'textarea.editor',
            height: 250,
            theme: 'modern',
            plugins: [ "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
				"searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
				"save table contextmenu directionality emoticons template paste textcolor placeholder"],
            // menubar: false,
            statusbar: false,
            toolbar1: 'insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | print preview media fullpage | forecolor backcolor emoticons',
            image_advtab: true,
            directionality : "auto",
            placeholder_attrs: {
                style: {
                    position: 'absolute',
                    top:'5px',
                    right:0,
                    color: '#888',
                    padding: '15px 7px',
                    width:'98%',
                    overflow: 'hidden',
                    'white-space': 'pre-wrap',
                    direction: 'rtl',
                    'text-align': 'right',
                }
            },
            setup: function (editor) {
                editor.on('change', function () {
                    tinymce.triggerSave();
                });
            }
        });
	}
	
})(jQuery);