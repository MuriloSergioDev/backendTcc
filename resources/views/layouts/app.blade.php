<!DOCTYPE html>
<html lang="pt-br">
<head>
	@component('includes.head')
	@endcomponent
</head>

<body>
	<header>
		@component('includes.header')
		@endcomponent
	</header>

	<main id="top">
		@yield('content')
	</main>
	<script
	src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.13/lottie.min.js"
	integrity="sha512-srGxQe2w7s50+5/nNgEVKYtBm15zRylJwdjxYnGEZr3mmHFJKFjA/ImA2OKizVzoIDX8XISMHDI1+az9pnumbQ=="
	crossorigin="anonymous"
	referrerpolicy="no-referrer"
	></script>

	<!--JS bootstrap-->
	<script
		src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
		integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
		crossorigin="anonymous"
	></script>

	<!--JS SWIPER-->
	<script src="https://unpkg.com/swiper@7/swiper-bundle.min.js"></script>

	<footer data-scroll>
		@component('includes.footer')
		@endcomponent
	</footer>

	{{-- sripts por CDN --}}


	<!--JS externo-->
	{{-- <script src="/public/js/main.js"></script> --}}


	{{--  custom scripts  --}}

	{{-- <span id="phplive_btn_1554989567" onclick="phplive_launch_chat_0(0)" style="color: #fff; text-decoration: underline; cursor: pointer; display:none;"></span>
	<script type="text/javascript">

	(function() {
	var phplive_e_1554989567 = document.createElement("script") ;
	phplive_e_1554989567.type = "text/javascript" ;
	phplive_e_1554989567.async = true ;
	phplive_e_1554989567.src = "//dhl.tecnologia.ws/phplive/js/phplive_v2.js.php?v=0|1554989567|0|" ;
	document.getElementById("phplive_btn_1554989567").appendChild( phplive_e_1554989567 ) ;
	})() ;

	</script> --}}

	<noscript>Your browser is outdated or does not support JavaScript</noscript>

	{{--  page scripts  --}}
	@yield('scripts')
</body>
</html>
