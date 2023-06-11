<meta charset="UTF-8">
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1">
<!--favicon -->
<link rel="icon" href="favicon.ico" type="image/x-icon"/>
<!--Bootstrap.min css-->
<link rel="stylesheet" href="/admin-assets/plugins/bootstrap/css/bootstrap.min.css">
<!--Icons css-->
<link rel="stylesheet" href="/admin-assets/css/icons.css">
<!--Style css-->
<link rel="stylesheet" href="/admin-assets/css/style.css?v=1.2">
<!--mCustomScrollbar css-->
<link rel="stylesheet" href="/admin-assets/plugins/scroll-bar/jquery.mCustomScrollbar.css">
<!--Sidemenu css-->
<link rel="stylesheet" href="/admin-assets/plugins/toggle-menu/sidemenu.css">
<!-- Toastr Plugin -->
<link rel="stylesheet" href="/admin-assets/plugins/toastr/build/toastr.css">
<!-- fancybox -->
<link rel="stylesheet" href="/admin-assets/plugins/fancybox/fancybox.css" />
<!-- select2 -->
<link rel="stylesheet" href="/admin-assets/plugins/select2/select2.css">
<!--bootstrap fileinput-->
<link href="/admin-assets/plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>
<link href="/admin-assets/plugins/bootstrap-fileinput/themes/explorer-fas/theme.css" rel="stylesheet" type="text/css"/>
@if( App::getLocale() == 'ar' )
    <!-- google font -->
    <link href="https://fonts.googleapis.com/css?family=Tajawal&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=El+Messiri&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="/admin-assets/css/rtl.css?v=1.1" >
@endif