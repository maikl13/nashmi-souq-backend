$.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});

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
    layoutTemplates: {main2: '{preview} {remove} {browse}', footer: footerTemplate},
    // allowedFileExtensions: ["jpg", "jpeg", "png"],
	initialPreviewAsData: true,
	showUpload: false,
	autoOrientImage: false,
}

// Javascript to enable link to tab
var url = document.location.toString();
if (url.match('#')) {
    $('.nav-tabs a[href="#' + url.split('#')[1] + '"]').tab('show');
} 
// Change hash for page-reload
$('.nav-tabs a').on('shown.bs.tab', function (e) {
    history.replaceState({}, '', location.pathname + e.target.hash);
})