<meta charset="utf-8" />
<title>{{ $config->nome ?? 'Bredi' }} | @yield('title', 'Dashboard')</title>

{{-- favicon --}}
<link rel="icon" sizes="192x192" href="/img/favicon.ico">
<link rel="icon" href="/img/favicon.ico" type="image/x-icon"/>
<link rel="shortcut icon" href="/img/favicon.ico" type="image/x-icon"/>

<meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" name="viewport" />
<meta content="" name="description" />
<meta content="" name="author" />

<!-- ================== BEGIN BASE CSS STYLE ================== -->
<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
<!-- ================== END BASE CSS STYLE ================== -->
<script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script><!-- begin #footer -->
{{-- Font Awesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
{{-- timepicker --}}
<link href="{{asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" />
{{-- select2 --}}
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js" defer></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
{{-- mask e inputmask --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> --}}
<script src="https://igorescobar.github.io/jQuery-Mask-Plugin/js/jquery.mask.min.js" defer></script>
{{-- WYSIHTML5 --}}
<link href="{{asset('./../assets/css/apple/app.min.css')}}" rel="stylesheet" />
<link href="{{asset('./../assets/plugins/ionicons/css/ionicons.min.css')}}" rel="stylesheet" />
<link href="{{asset('./../assets/plugins/bootstrap3-wysihtml5-bower/dist/bootstrap3-wysihtml5.min.css')}}" rel="stylesheet" />

{{-- Loading Modal --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-loadingModal@1.0.2/css/jquery.loadingModal.css">

{{-- TIMEPICKER --}}
<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js"></script>
@stack('css')
