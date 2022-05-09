<!-- Jquery Js -->
<script src="/assets/plugins/jquery/js/jquery.min.js"></script>
<!-- Popper Js -->
<script src="/assets/plugins/popper.js/js/popper.min.js"></script>
<!-- Bootstrap Js -->
<script src="/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<!-- Waypoints Js -->
<script src="/assets/plugins/waypoints/js/jquery.waypoints.min.js"></script>
<!-- Counterup Js -->
<script src="/assets/plugins/jquery.counterup/js/jquery.counterup.min.js"></script>
<!-- Owl Carousel Js -->
<script src="/assets/plugins/owl.carousel/js/owl.carousel.min.js"></script>
<!-- ImagesLoaded Js -->
<script src="/assets/plugins/imagesloaded/js/imagesloaded.pkgd.min.js"></script>
<!-- Isotope Js -->
<script src="/assets/plugins/isotope-layout/js/isotope.pkgd.min.js"></script>
<!-- Animated Headline Js -->
<script src="/assets/plugins/jquery-animated-headlines/js/jquery.animatedheadline.min.js"></script>
<!-- Magnific Popup Js -->
<script src="/assets/plugins/magnific-popup/js/jquery.magnific-popup.min.js"></script>
<!-- ElevateZoom Js -->
<script src="/assets/plugins/elevatezoom/js/jquery.elevateZoom-2.2.3.min.js"></script>
<!-- Bootstrap Validate Js -->
<script src="/assets/plugins/bootstrap-validator/js/validator.min.js"></script>
<!-- Meanmenu Js -->
<script src="/assets/plugins/meanmenu/js/jquery.meanmenu.min.js"></script>
<!-- Google Map js -->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBtmXSwv4YmAKtcZyyad9W7D4AC08z0Rb4"></script>
<!--bootstrap fileinput-->
<script src="/admin-assets/plugins/bootstrap-fileinput/js/fileinput.js" type="text/javascript"></script>
<script src="/admin-assets/plugins/bootstrap-fileinput/js/locales/ar.js" type="text/javascript"></script>
<!-- Toast Plugin -->
<script src="/admin-assets/plugins/toastr/build/toastr.min.js"></script>
<!--Sweetalert-->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<!-- Site Scripts -->
<script>var mobileLogo = '{{ setting('logo') }}', countryCode = '{{ country()->code }}';</script>
<script src="/assets/js/app.js?v=1.3"></script>
@auth
	<script src="/assets/js/realtime.js"></script>
	<script src="/assets/js/chat.js?v=1.2"></script>
@endauth
<script src="/assets/js/custom.js?v=1.1"></script>
<script src="/assets/js/ajax/store.js?v=1.2" defer></script>

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

<!-- GetButton.io widget -->
{{-- <script type="text/javascript">
    (function () {
        var options = {
            facebook: "108589284172449", // Facebook page ID
            whatsapp: "+201283024411", // WhatsApp number
            call_to_action: "", // Call to action
            button_color: "#E74339", // Color of button
            position: "left", // Position may be 'right' or 'left'
            order: "facebook,whatsapp", // Order of buttons
        };
        var proto = document.location.protocol, host = "getbutton.io", url = proto + "//static." + host;
        var s = document.createElement('script'); s.type = 'text/javascript'; s.async = true; s.src = url + '/widget-send-button/js/init.js';
        s.onload = function () { WhWidgetSendButton.init(host, proto, options); };
        var x = document.getElementsByTagName('script')[0]; x.parentNode.insertBefore(s, x);
    })();
</script> --}}
<!-- /GetButton.io widget -->