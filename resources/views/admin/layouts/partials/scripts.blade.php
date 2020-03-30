<!--Jquery.min js-->
<script src="/admin-assets/js/jquery.min.js"></script>
<!--popper js-->
<script src="/admin-assets/js/popper.js"></script>
<!--Tooltip js-->
<script src="/admin-assets/js/tooltip.js"></script>
<!--Bootstrap.min js-->
<script src="/admin-assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!--Jquery.nicescroll.min js-->
<script src="/admin-assets/plugins/nicescroll/jquery.nicescroll.min.js"></script>
<!--Scroll-up-bar.min js-->
<script src="/admin-assets/plugins/scroll-up-bar/dist/scroll-up-bar.min.js"></script>
<!--mCustomScrollbar js-->
<script src="/admin-assets/plugins/scroll-bar/jquery.mCustomScrollbar.concat.min.js"></script>
<!--Sidemenu js-->
<script src="/admin-assets/plugins/toggle-menu/sidemenu.js"></script>
<!--Othercharts js-->
<script src="/admin-assets/plugins/othercharts/jquery.knob.js"></script>
<script src="/admin-assets/plugins/othercharts/jquery.sparkline.min.js"></script>
<!--Scripts js-->
<script src="/admin-assets/js/scripts.js"></script>
<!--tinymce-->
<script src="/admin-assets/plugins/tinymce/tinymce.min.js"></script>
<!--Scripts js-->
<script src="/admin-assets/js/formeditor.js"></script>
<!--DataTables js-->
<script src="/admin-assets/plugins/Datatable/js/jquery.dataTables.js"></script>
<script src="/admin-assets/plugins/Datatable/js/dataTables.bootstrap4.js"></script>
<!-- select2 -->
<script src="/admin-assets/plugins/select2/select2.full.js"></script>
<!-- Toast Plugin -->
<script src="/admin-assets/plugins/toastr/build/toastr.min.js"></script>
<!--Sweetalert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<!--fancybox-->
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<!--bootstrap fileinput-->
<script src="/admin-assets/plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="/admin-assets/plugins/bootstrap-fileinput/js/locales/ar.js" type="text/javascript"></script>

<script type="text/javascript">
	$('.select2').select2();
	$('.select2-tags').select2({
    	placeholder: "قم باضافة الكلمات المفتاحية *",
    	tags: true,
		maximumSelectionLength: 30,
    	"language": {
	       "noResults": function(){ return "قم باضافة كلمة مفتاحية واحدة على الأقل."; },
	       "maximumSelected": function(){ return "لا يمكن اضافة أكثر من 30 كلمة مفتاحية!"; }
	    }
	});
	$.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>

<script type="text/javascript">
	$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

	var actionsTemplate = '<div class="file-actions"><div class="file-footer-buttons"><button type="button" class="kv-file-remove btn btn-xs btn-info" title="Remove file" data-url="" data-key=""><i class="fa fa-trash"></i></button> <button type="button" class="kv-file-zoom btn btn-xs btn-info" title="View Details"><i class="fa fa-search-plus"></i></button></div><br></div>';

	var footerTemplate = '<div class="wt-uploadingbar"><span class="uploadprogressbar"></span><p style="width:190px;word-break:break-all;line-height: 20px;">{caption}</p><div class="text-center">{actions}</div></div>';

	var fileInputOptions = {
	    // overwriteInitial: false,
	    language: "ar",
	    maxFileSize: 8096,
	    showClose: false,
	    showCaption: false,
	    browseLabel: 'اختيار صورة',
	    removeLabel: 'ازالة',
	    browseIcon: '<i class="fa fa-folder"></i>',
	    removeIcon: '<i class="fa fa-trash"></i>',
	    removeTitle: 'ازالة الصوره',
	    elErrorContainer: '#kv-avatar-errors-1',
	    browseClass: "btn btn-primary",
	    removeClass: "btn btn-danger",
	    defaultPreviewContent: '',
	    layoutTemplates: {main2: '{preview} {remove} {browse}', footer: footerTemplate, /*actions: actionsTemplate*/},
	    // allowedFileExtensions: ["jpg", "jpeg", "png"],
    	initialPreviewAsData: true,
    	showUpload: false,
    	autoOrientImage: false,
	}
</script>

<script type="text/javascript">
    toastr.options.progressBar = true;

	@if (session('success'))
    	toastr.options.timeOut = 5000;
	    toastr.success( "{{ session('success') }}" );

	@elseif (session('failure'))
    	toastr.options.timeOut = 7000;
	    toastr.error( "{{ session('failure') }}" );

	@elseif ($errors->any())
    	toastr.options.timeOut = 10000;
        @foreach ($errors->all() as $error)
	    	toastr.error( "{{ $error }}" );
        @endforeach
	@endif
</script>