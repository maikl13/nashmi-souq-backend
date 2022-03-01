<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="">
@auth
	<meta name="username" content="{{ Auth::user()->username }}">
@endauth
<!-- Favicon -->
<link rel="shortcut icon" type="image/x-icon" href="/assets/images/favicon.png">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="/assets/plugins/bootstrap/css/bootstrap.min.css">
<link rel="stylesheet" href="/admin-assets/plugins/iconfonts/Glyphicons/glyphicon.css">
<!-- FontAwesome CSS -->
<link rel="stylesheet" href="/assets/plugins/fontawesome/css/all.min.css">
<!-- Flaticon CSS -->
<link rel="stylesheet" href="/assets/plugins/flaticon/flaticon.css">
<!-- Owl Carousel CSS -->
<link rel="stylesheet" href="/assets/plugins/owl.carousel/css/owl.carousel.min.css">
<link rel="stylesheet" href="/assets/plugins/owl.carousel/css/owl.theme.default.min.css">
<!-- Animated Headlines CSS -->
<link rel="stylesheet" href="/assets/plugins/jquery-animated-headlines/css/jquery.animatedheadline.css">
<!-- Magnific Popup CSS -->
<link rel="stylesheet" href="/assets/plugins/magnific-popup/css/magnific-popup.css">
<!-- Animate CSS -->
<link rel="stylesheet" href="/assets/plugins/animate.css/css/animate.min.css">
<!-- Meanmenu CSS -->
<link rel="stylesheet" href="/assets/plugins/meanmenu/css/meanmenu.min.css">
<!--bootstrap fileinput-->
<link href="/admin-assets/plugins/bootstrap-fileinput/css/fileinput.css" rel="stylesheet" type="text/css"/>
<link href="/admin-assets/plugins/bootstrap-fileinput/themes/explorer-fas/theme.css" rel="stylesheet" type="text/css"/>
<!-- Toastr Plugin -->
<link rel="stylesheet" href="/admin-assets/plugins/toastr/build/toastr.css">
<!-- Site Stylesheet -->
<link rel="stylesheet" href="/assets/css/app.css?v=1.4">
<link rel="stylesheet" href="/assets/css/rtl.css">
@auth
	<link rel="stylesheet" href="/assets/css/chat.css">
@endauth
<link rel="stylesheet" href="/assets/css/style.css?v=1.5">

<!-- Google Web Fonts -->
<link href="https://fonts.googleapis.com/css?family=Nunito:300,300i,400,400i,600,600i,700,700i,800,800i&display=swap" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i,700,700i,900,900i&display=swap" rel="stylesheet">
{{-- <link href="https://fonts.googleapis.com/css?family=Tajawal&display=swap" rel="stylesheet"> --}}
{{-- <link href="https://fonts.googleapis.com/css?family=Cairo&display=swap" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css?family=Almarai&display=swap" rel="stylesheet">

<!-- Google Adsense -->
<script data-ad-client="ca-pub-1250310795030706" async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
