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
    layoutTemplates: {main2: '{preview} {remove} {browse}', footer: footerTemplate, actions: actionsTemplate},
    // allowedFileExtensions: ["jpg", "jpeg", "png"],
	initialPreviewAsData: true,
	showUpload: false,
	autoOrientImage: false,
}