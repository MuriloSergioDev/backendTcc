<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
	@include('controle.includes.head')
</head>
@php
	$bodyClass = (!empty($boxedLayout)) ? 'boxed-layout ' : '';
	$bodyClass .= (!empty($paceTop)) ? 'pace-top ' : '';
	$bodyClass .= (!empty($bodyExtraClass)) ? $bodyExtraClass . ' ' : '';
@endphp
<body class="{{ $bodyClass }}">
	
	@include('controle.includes.component.page-loader')
	@include('controle.includes.page-js')
	
	@yield('content')
			
</body>
</html>
