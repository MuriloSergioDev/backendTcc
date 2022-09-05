@php
	$headerClass = (!empty($headerInverse)) ? 'navbar-inverse ' : 'navbar-default ';
	$headerMenu = (!empty($headerMenu)) ? $headerMenu : '';
	$headerMegaMenu = (!empty($headerMegaMenu)) ? $headerMegaMenu : ''; 
	$headerTopMenu = (!empty($headerTopMenu)) ? $headerTopMenu : '';
@endphp

<!-- begin #header -->
<div id="header" class="header {{ $headerClass }}">
	<!-- begin navbar-header -->
	<div class="navbar-header">
		@if ($sidebarTwo)
		<button type="button" class="navbar-toggle pull-left" data-click="right-sidebar-toggled">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		@endif
		@if (isset($config->config['layout']['logo']))
		<a href="{{ route('dashboard') }}" class="navbar-brand"><img src="{{ route('imagem.render', "company/p/". $config->config['layout']['logo']) }}" alt="" class="img-fluid ml-5"><span class="navbar-logo"></span><b>{{ $config->nome }}</b></a>
		@else
		<a href="{{ route('dashboard') }}" class="navbar-brand"></span><b>Bredi</b></a>
		@endif
		@if ($headerMegaMenu)
			<button type="button" class="navbar-toggle pt-0 pb-0 mr-0" data-toggle="collapse" data-target="#top-navbar">
				<span class="fa-stack fa-lg text-inverse">
					<i class="far fa-square fa-stack-2x"></i>
					<i class="fa fa-cog fa-stack-1x"></i>
				</span>
			</button>
		@endif
		@if (!$sidebarHide && $topMenu)
			<button type="button" class="navbar-toggle pt-0 pb-0 mr-0 collapsed" data-click="top-menu-toggled">
				<span class="fa-stack fa-lg text-inverse">
					<i class="far fa-square fa-stack-2x"></i>
					<i class="fa fa-cog fa-stack-1x"></i>
				</span>
			</button>
		@endif
		@if (!$sidebarHide && !$headerTopMenu)
		<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		@endif
		@if ($headerTopMenu)
			<button type="button" class="navbar-toggle" data-click="top-menu-toggled">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		@endif
	</div>
	<!-- end navbar-header -->
	
	@includeWhen($headerMegaMenu, 'controle.includes.header-mega-menu')
	
	<!-- begin header-nav -->
	<ul class="navbar-nav navbar-right">
		@isset($headerLanguageBar)
		<li class="dropdown navbar-language">
			<a href="#" class="dropdown-toggle pr-1 pl-1 pr-sm-3 pl-sm-3" data-toggle="dropdown">
				<span class="flag-icon flag-icon-us" title="us"></span>
				<span class="name d-none d-sm-inline">EN</span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu">
				<a href="javascript:;" class="dropdown-item"><span class="flag-icon flag-icon-us" title="us"></span> English</a>
				<a href="javascript:;" class="dropdown-item"><span class="flag-icon flag-icon-cn" title="cn"></span> Chinese</a>
				<a href="javascript:;" class="dropdown-item"><span class="flag-icon flag-icon-jp" title="jp"></span> Japanese</a>
				<a href="javascript:;" class="dropdown-item"><span class="flag-icon flag-icon-be" title="be"></span> Belgium</a>
				<div class="dropdown-divider"></div>
				<a href="javascript:;" class="dropdown-item text-center">more options</a>
			</div>
		</li>
		@endisset
		<li class="dropdown navbar-user">
			<a href="#" class="dropdown-toggle" data-toggle="dropdown">
				@if (isset(Auth::user()->imagem))
					<img src="{{ route('imagem.render', "user/p/". Auth::user()->imagem) }}" alt="" />
				@else
					<img src="/assets/img/user/user-12.jpg" alt="" />
				@endif
				<span class="d-none d-md-inline">{{ Auth::user()->name }}</span> <b class="caret"></b>
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<x-jet-dropdown-link href="{{ route('controle.profile.edit') }}" class="dropdown-item">Perfil</x-jet-dropdown-link>
				<!-- Authentication -->
				<form method="POST" action="{{ route('logout') }}">
				@csrf
				<x-jet-dropdown-link href="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();" class="dropdown-item">
					{{ __('Sair') }}
						</x-jet-dropdown-link>
					</form>
			</div>
		</li>
		@if($sidebarTwo)
		<li class="divider d-none d-md-block"></li>
		<li class="d-none d-md-block">
			<a href="javascript:;" data-click="right-sidebar-toggled" class="f-s-14">
				<i class="fa fa-th"></i>
			</a>
		</li>
		@endif
	</ul>
	<!-- end header navigation right -->
</div>
<!-- end #header -->
