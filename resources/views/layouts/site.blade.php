<!DOCTYPE html>
<html lang="pt-br">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Bredi - http://www.bredi.com.br">
	<meta name="author" content="Luique Cruz - www.luiquecruz.com">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="author" content="Paysandu - http://www.paysandu.com.br" />
	<meta property="og:url" content="http://www.paysandu.com.br/" />
	
	<title>{{ env('APP_NAME') }}</title>
	
	<meta name="keywords" content="Paysandu, Papão, Serie B, Sport, Club, clube, norte, Belém, Pará, time, Parazão, escudo, hino, mascote, bicolor, nação, tabela, classificação" />
	<meta property="og:description" content="">
	<meta name="description" content="">
	<meta property="og:url" content="">
	<meta property="og:title" content="Paysandu">
	<meta property="og:image" content="/img/site/logo/logo.png">
	<meta property="og:image:type" content="image/jpeg">
	<meta property="og:image:width" content="170">
	<meta property="og:image:height" content="170">
	<meta property="og:site_name" content="">
	<meta property="og:type" content="website">

	<!--TWITTER META TAG-->
	<meta name="twitter:card" content="">
	<meta name="twitter:title" content="Paysandu">
	<meta name="twitter:url" content="">
	<meta name="twitter:description" content="Website Paysandu Sport Club">
	<meta name="twitter:image" content="/img/site/logo/logo.png"> <!-- image size 120x120 -->
	<!--TWITTER META TAG END-->

	<!-- change colors according site theme -->
	<meta name="msapplication-navbutton-color" content="#FFFFFF"/> <!-- MS -->
	<meta name="apple-mobile-web-app-status-bar-style" content="#FFFFFF"> <!-- APPLE -->
	<meta name="theme-color" content="#FFFFFF"> <!-- META TAG ANDROID 5 -->

	<link rel="icon" sizes="192x192" href="img/site/logo/fav.png">
	<link rel="icon" href="/img/site/logo/fav.png" type="image/x-icon"/>
	<link rel="shortcut icon" href="/img/site/logo/fav.png" type="image/x-icon"/>
	
	<!-- fonts  -->
	 <link href="/fonts/site/fonts.css" rel="stylesheet"> 

	<!-- pretty checkbox -->
	<link href="https://cdn.jsdelivr.net/npm/pretty-checkbox@3.0/dist/pretty-checkbox.min.css" rel="stylesheet">

	<!-- Lightbox2 -->
	{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/css/lightbox.min.css"> --}}

	{{--  custom stylesheets  --}}
	<link href="{{ asset('/css/site/vendor.css') }}" rel="stylesheet"/>
	<link href="{{ asset('/css/site/app.css') }}" rel="stylesheet"/>
	<link href="{{ asset('/css/site/media-queries.css') }}" rel="stylesheet"/>

	@yield('styles')
</head>
<body>

	<header>
		{{-- desktop navbar --}}
		<div class="desktop-bar hidden-xs">
			<div class="container">
				<div class="flex-wrapper">
					<div class="left-content">
						<div class="logo">
							<a href="{{ route('site.index.index') }}">
								<img src="/img/site/logo/paysandu.png" alt="logomarca paysandu">
							</a>
						</div>
	
						<div class="complement hidden-sm">
							<div class="info-block">
								<div class="title">
									<a href="{{ route('site.index.index') }}">
										<strong>PAYSANDU</strong>
										<br>
										<span>SITE OFICIAL</span>
									</a>
								</div>
	
								<div class="social hidden-md">
									<ul class="list-inline">
										<li>
											<a href="#" target="_blank" rel="noopener">
												<img src="/img/site/icons/facebook.svg" alt="facebook">
											</a>
										</li>
										<li>
											<a href="#" target="_blank" rel="noopener">
												<img src="/img/site/icons/twitter.svg" alt="twitter">
											</a>
										</li>
										<li>
											<a href="#" target="_blank" rel="noopener">
												<img src="/img/site/icons/youtube.svg" alt="youtube">
											</a>
										</li>
										<li>
											<a href="#" target="_blank" rel="noopener">
												<img src="/img/site/icons/instagram.svg" alt="instagram">
											</a>
										</li>
										<li>
											<a href="#" target="_blank" rel="noopener">
												<img src="/img/site/icons/flickr.svg" alt="flickr">
											</a>
										</li>
										<li>
											<a href="#" target="_blank" rel="noopener">
												<img src="/img/site/icons/snapchat.svg" alt="snapchat">
											</a>
										</li>
									</ul>
								</div>
							</div> <!-- end info-block -->
	
							<div class="socio-block">
								<div class="socio-bar">
									<span class="text">Já somos</span>
									
									<div class="counter">
										<span class="numbers">7963</span>
										<hr class="strike">
									</div>

									<span class="text">Sócios adimplentes</span>

									<a href="#" class="btn-socio" target="_blank" rel="noopener">Sócio bicolor</a>
								</div>
							</div> <!-- end socio-block -->
						</div> <!-- end complement -->
					</div> <!-- end left-content -->
	
					<div class="right-content">
						<div class="top-items">
							<div class="socio-bar">
								<span class="text">Já somos</span>
								
								<div class="counter">
									<span class="numbers">7963</span>
									<hr class="strike">
								</div>
	
								<span class="text">Sócios adimplentes</span>
	
								<a href="#" class="btn-socio" target="_blank" rel="noopener">Sócio bicolor</a>
							</div>

							<div class="sponsor">
								<a href="#" target="_blank" rel="noopener">
									<img src="/img/site/elements/brands/caixa1.png" alt="caixa economica federal">
								</a>
							</div>
						</div> <!-- end top-items -->

						<div class="bottom-items">
							<ul class="nav">
								<li class="hidden-sm hidden-md home">
									<a href="{{ route('site.index.index') }}" class="">HOME</a>
								</li>

								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="dropdown-title">O CLUBE</span>
									</a>
									<ul class="dropdown-menu">
										{{-- <li>
											<a href="{{ route('site.index.index') }}">História</a>
										</li> --}}
										<li>
											<a href="{{ route('site.simbolos.index') }}">Símbolos</a>
										</li>
										<li>
											<a href="{{ route('site.titulos.index') }}">Títulos</a>
										</li>
										<li>
											<a href="{{ route('site.estatuto.index') }}">Estatuto</a>
										</li>
										<li>
											<a href="{{ route('site.estrutura.estadio') }}">Estrutura</a>
										</li>
										<li>
											<a href="{{ route('site.poderes.diretoria') }}">Os Poderes</a>
										</li>
										<li>
											<a href="{{ route('site.transparencia.balancos') }}">Transparência</a>
										</li>
										<li>
											<a href="{{ route('site.licenciamento.index') }}">Licenciamento</a>
										</li>
										<li>
											<a href="{{ route('site.torcida.index') }}">Torcida</a>
										</li>
										<li>
											<a href="{{ route('site.contato.ouvidoria') }}">Ouvidoria</a>
										</li>
										<li>
											<a href="{{ route('site.contato.index') }}">Contato</a>
										</li>
									</ul>
								</li> <!-- end dropdown -->

								<li class="dropdown">
									<a class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
										<span class="dropdown-title">ESPORTES</span>
									</a>
									<ul class="dropdown-menu">
										<li>
											<a href="{{ route('site.futebol.agenda') }}">Futebol</a>
										</li>
										<li>
											<a href="{{ route('site.esportes.basquete') }}">Basquete</a>
										</li>
										<li>
											<a href="{{ route('site.esportes.nautica') }}">Náutica</a>
										</li>
										<li>
											<a href="{{ route('site.esportes.futsal') }}">Futsal</a>
										</li>
										<li>
											<a href="{{ route('site.esportes.handebol') }}">Handebol</a>
										</li>
										<li>
											<a href="{{ route('site.esportes.volei') }}">Volei</a>
										</li>
										<li>
											<a href="{{ route('site.esportes.tenis') }}">Tênis</a>
										</li>
									</ul>
								</li> <!-- end dropdown -->

								<li>
									<a href="{{ route('site.noticias.index') }}" class="">NOTÍCIAS</a>
								</li>

								<li>
									<a href="#" class="">INGRESSOS</a>
								</li>

								<li class="link-loja">
									<a href="http://www.lojalobo.com.br/loja-virtual/" class="btn-outline --white-style  --wolf-white" target="_blank" rel="noopener">LOJA <span class="hidden-sticky">VIRTUAL</span></a>
								</li>
							</ul>
						</div>
					</div> <!-- end right-content -->
				</div> <!-- end flex-wrapper -->
			</div> <!-- end container -->
		</div>

		{{-- mobile navbar --}}
		<nav class="navbar navbar-fixed-top visible-xs">
			<div class="container">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>

					<ul class="nav-options list-inline ">
						<li class="item-1">
							<a class="navbar-brand visible-xs" href="{{ route('site.index.index') }}">
								<img src="/img/site/logo/paysandu.png" alt="Logo">
							</a>
						</li>

						<li class="item-2">
							<div class="title">
								<a href="{{ route('site.index.index') }}">
									<strong>PAYSANDU</strong>
									<br>
									<span>SITE OFICIAL</span>
								</a>
							</div>
						</li>
					</ul>
				</div>

				<div class="collapse navbar-collapse" id="navbar">

					<ul class="menu nav navbar-nav navbar-right">
						<li class="social">
							<div class="social">
								<ul class="list-inline">
									<li>
										<a href="#" target="_blank" rel="noopener">
											<img src="/img/site/icons/facebook.svg" alt="facebook">
										</a>
									</li>
									<li>
										<a href="#" target="_blank" rel="noopener">
											<img src="/img/site/icons/twitter.svg" alt="twitter">
										</a>
									</li>
									<li>
										<a href="#" target="_blank" rel="noopener">
											<img src="/img/site/icons/youtube.svg" alt="youtube">
										</a>
									</li>
									<li>
										<a href="#" target="_blank" rel="noopener">
											<img src="/img/site/icons/instagram.svg" alt="instagram">
										</a>
									</li>
									<li>
										<a href="#" target="_blank" rel="noopener">
											<img src="/img/site/icons/flickr.svg" alt="flickr">
										</a>
									</li>
									<li>
										<a href="#" target="_blank" rel="noopener">
											<img src="/img/site/icons/snapchat.svg" alt="snapchat">
										</a>
									</li>
								</ul>
							</div>
						</li>
						<li class="title">
							<p>O CLUBE</p>
							<div class="separator"></div>
						</li>
						{{-- <li>
							<a href="{{ route('site.index.index') }}">História</a>
						</li> --}}
						<li>
							<a href="{{ route('site.simbolos.index') }}">Símbolos</a>
						</li>
						<li>
							<a href="{{ route('site.titulos.index') }}">Títulos</a>
						</li>
						<li>
							<a href="{{ route('site.estatuto.index') }}">Estatuto</a>
						</li>
						<li>
							<a href="{{ route('site.estrutura.estadio') }}">Estrutura</a>
						</li>
						<li>
							<a href="{{ route('site.poderes.diretoria') }}">Os Poderes</a>
						</li>
						<li>
							<a href="{{ route('site.transparencia.balancos') }}">Transparência</a>
						</li>
						<li>
							<a href="{{ route('site.licenciamento.index') }}">Licenciamento</a>
						</li>
						<li>
							<a href="{{ route('site.torcida.index') }}">Torcida</a>
						</li>
						<li>
							<a href="{{ route('site.contato.ouvidoria') }}">Ouvidoria</a>
						</li>
						<li>
							<a href="{{ route('site.contato.index') }}">Contato</a>
						</li>


						<li class="title">
							<p class="">ESPORTES</p>
							<div class="separator"></div>
						</li>
						<li>
							<a href="{{ route('site.futebol.agenda') }}">Futebol</a>
						</li>
						<li>
							<a href="{{ route('site.esportes.basquete') }}">Basquete</a>
						</li>
						<li>
							<a href="{{ route('site.esportes.nautica') }}">Náutica</a>
						</li>
						<li>
							<a href="{{ route('site.esportes.futsal') }}">Futsal</a>
						</li>
						<li>
							<a href="{{ route('site.esportes.handebol') }}">Handebol</a>
						</li>
						<li>
							<a href="{{ route('site.esportes.volei') }}">Volei</a>
						</li>
						<li>
							<a href="{{ route('site.esportes.tenis') }}">Tênis</a>
						</li>

						<li class="title">
							<p class="">OUTROS LINKS</p>
							<div class="separator"></div>
						</li>
						<li>
							<a href="{{ route('site.noticias.index') }}" class="">Notícias</a>
						</li>

						<li>
							<a href="#" class="">Ingressos</a>
						</li>

						<li>
							<a href="#" class="">Loja Virtual</a>
						</li>
					</ul>
				</div> <!-- end navbar-collapse -->
			</div> <!-- end container -->
		</nav> <!-- end navbar -->
	</header>

	<main id="top">
		@yield('conteudo')
	</main>

	<footer>
		<div class="brands">
			<div class="master-sponsors">
				<div class="container">
					<p class="title">Patrocinador Master</p>
	
					<div class="flex-wrapper">
						<div class="item">
							<img src="/img/site/elements/brands/caixa1.png" alt="caixa" class="img-responsive">
						</div>
	
						<div class="item">
							<img src="/img/site/elements/brands/brasil.png" alt="brasil" class="img-responsive">
						</div>
					</div> <!-- end flex-wrapper -->
				</div> <!-- end container -->
			</div>
			
			<div class="sponsors">
				<div class="container">
					<p class="title">Patrocinador</p>
	
					<div class="flex-wrapper">
						<div class="item">
							<img src="/img/site/elements/brands/alubar.png" alt="alubar" class="img-responsive">
						</div>
						
						<div class="item">
							<img src="/img/site/elements/brands/arm-paraiba.png" alt="arm-paraiba" class="img-responsive">
						</div>
						
						<div class="item">
							<img src="/img/site/elements/brands/glacial.png" alt="glacial" class="img-responsive">
						</div>

						<div class="item">
							<img src="/img/site/elements/brands/terranew.png" alt="terranew" class="img-responsive">
						</div>

						<div class="item">
							<img src="/img/site/elements/brands/globo.png" alt="globo" class="img-responsive">
						</div>

						<div class="item">
							<img src="/img/site/elements/brands/trigolino.png" alt="trigolino" class="img-responsive">
						</div>

						<div class="item">
							<img src="/img/site/elements/brands/sky.png" alt="sky" class="img-responsive">
						</div>

						<div class="item">
							<img src="/img/site/elements/brands/husqvarna.png" alt="husqvarna" class="img-responsive">
						</div>

						<div class="item">
							<img src="/img/site/elements/brands/mirella.png" alt="mirella" class="img-responsive">
						</div>

						<div class="item">
							<img src="/img/site/elements/brands/uber.png" alt="uber" class="img-responsive">
						</div>
					</div> <!-- end flex-wrapper -->
				</div> <!-- end container -->
			</div>
			
			<div class="partners">
				<div class="container">
					<p class="title">Parceiros</p>
	
					<div class="flex-wrapper">
						<div class="item">
							<img src="/img/site/elements/brands/amaral-costa.png" alt="amaral-costa" class="img-responsive">
						</div>
	
						<div class="item">
							<img src="/img/site/elements/brands/caeex.png" alt="caeex" class="img-responsive">
						</div>
	
						<div class="item">
							<img src="/img/site/elements/brands/desportiva.png" alt="desportiva" class="img-responsive">
						</div>
	
						<div class="item">
							<img src="/img/site/elements/brands/h-porto-dias.png" alt="h-porto-dias" class="img-responsive">
						</div>
	
						<div class="item">
							<img src="/img/site/elements/brands/lmcloud.png" alt="lmcloud" class="img-responsive">
						</div>
	
						<div class="item">
							<img src="/img/site/elements/brands/dimagem.png" alt="dimagem" class="img-responsive">
						</div>
	
						<div class="item">
							<img src="/img/site/elements/brands/connecta.png" alt="connecta" class="img-responsive">
						</div>

						<div class="item --different">
							<img src="/img/site/elements/brands/macaco-velho.png" alt="macaco-velho" class="img-responsive">
							<p class="description">Agência Oficial do Paysandu</p>
						</div>
	
						<div class="item --different">
							<img src="/img/site/elements/brands/studio-lumiar.png" alt="studio-lumiar" class="img-responsive">
							<p class="description">Produtora do Paysandu</p>
						</div>
	
						<div class="item --different">
							<img src="/img/site/elements/brands/bredi.png" alt="bredi" class="img-responsive">
							<p class="description">Agência Web Oficial do Paysandu</p>
						</div>
					</div> <!-- end flex-wrapper -->
				</div> <!-- end container -->
			</div>
			
			<div class="investor">
				<div class="container">
					<div class="flex-wrapper">
						<p class="title">Este site é um <br> oferecimento:</p>
	
						<div class="item">
							<img src="/img/site/elements/brands/pinheiro-sereni.png" alt="pinheiro sereni" class="img-responsive">
						</div>
					</div> <!-- end flex-wrapper -->
				</div> <!-- end container -->
			</div>
		</div> <!-- end components -->

		<div class="layer-1">
			<div class="container">
				<div class="btt">
					<a href="#top" class="btn-btt">
						<img src="/img/site/icons/arrow-top.svg" title="Back to top" alt="seta de navegação">
					</a>
				</div>

				<div class="flex-wrapper">
					<div class="logo">
						<a href="{{ route('site.index.index') }}">
							<img src="/img/site/logo/paysandu-footer.png" alt="paysandu logo alternativa">
						</a>
					</div>

					<div class="site-map">
						<div class="hidden-xs">
							<p class="title">O CLUBE</p>
							<ul class="links-footer">
								<li>
									<a href="{{ route('site.index.index') }}">História</a>
								</li>
								<li>
									<a href="{{ route('site.simbolos.index') }}">Símbolos</a>
								</li>
								<li>
									<a href="{{ route('site.titulos.index') }}">Títulos</a>
								</li>
								<li>
									<a href="{{ route('site.estatuto.index') }}">Estatuto</a>
								</li>
								<li>
									<a href="{{ route('site.estrutura.estadio') }}">Estrutura</a>
								</li>
								<li>
									<a href="{{ route('site.poderes.diretoria') }}">Os Poderes</a>
								</li>
								<li>
									<a href="{{ route('site.transparencia.balancos') }}">Transparência</a>
								</li>
								<li>
									<a href="{{ route('site.licenciamento.index') }}">Licenciamento</a>
								</li>
								<li>
									<a href="{{ route('site.torcida.index') }}">Torcida</a>
								</li>
								<li>
									<a href="{{ route('site.contato.ouvidoria') }}">Ouvidoria</a>
								</li>
								<li>
									<a href="{{ route('site.contato.index') }}">Contato</a>
								</li>
							</ul>
						</div>

						<div class="hidden-xs">
							<p class="title">ESPORTES</p>
							<ul class="links-footer">
								<li>
									<a href="{{ route('site.futebol.agenda') }}">Futebol</a>
								</li>
								<li>
									<a href="{{ route('site.esportes.basquete') }}">Basquete</a>
								</li>
								<li>
									<a href="{{ route('site.esportes.nautica') }}">Náutica</a>
								</li>
								<li>
									<a href="{{ route('site.esportes.futsal') }}">Futsal</a>
								</li>
								<li>
									<a href="{{ route('site.esportes.handebol') }}">Handebol</a>
								</li>
								<li>
									<a href="{{ route('site.esportes.volei') }}">Volei</a>
								</li>
								<li>
									<a href="{{ route('site.esportes.tenis') }}">Tênis</a>
								</li>
							</ul>
						</div>

						<div class="hidden-xs hidden-sm">
							<p class="title">LOJA VIRTUAL</p>
							<ul class="links-footer">
								<li>
									<a href="http://www.lojalobo.com.br/loja-virtual/acervo/?id_segmento=1" target="_blank" rel="noopener">Masculino</a>
								</li>
								<li>
									<a href="http://www.lojalobo.com.br/loja-virtual/acervo/?id_segmento=2" target="_blank" rel="noopener">Feminino</a>
								</li>
								<li>
									<a href="http://www.lojalobo.com.br/loja-virtual/acervo/?id_segmento=3" target="_blank" rel="noopener">Infantil</a>
								</li>
							</ul>
						</div>
					</div>

					<div class="links">
						<ul class="links-footer">
							<li>
								<a href="{{ route('site.noticias.index') }}">NOTÍCIAS</a>
							</li>
							<li>
								<a href="#" target="_blank" rel="noopener">INGRESSOS</a>
							</li>
							<li>
								<a href="#" target="_blank" rel="noopener">SÓCIO BICOLOR</a>
							</li>
						</ul>
					</div>

					<div class="social">
						<ul class="list-inline">
							<li>
								<a href="#" target="_blank" rel="noopener">
									<img src="/img/site/icons/facebook.svg" alt="facebook">
								</a>
							</li>
							<li>
								<a href="#" target="_blank" rel="noopener">
									<img src="/img/site/icons/twitter.svg" alt="twitter">
								</a>
							</li>
							<li>
								<a href="#" target="_blank" rel="noopener">
									<img src="/img/site/icons/youtube.svg" alt="youtube">
								</a>
							</li>
							<li>
								<a href="#" target="_blank" rel="noopener">
									<img src="/img/site/icons/instagram.svg" alt="instagram">
								</a>
							</li>
							<li>
								<a href="#" target="_blank" rel="noopener">
									<img src="/img/site/icons/flickr.svg" alt="flickr">
								</a>
							</li>
							<li>
								<a href="#" target="_blank" rel="noopener">
									<img src="/img/site/icons/snapchat.svg" alt="snapchat">
								</a>
							</li>
						</ul>
					</div>

					<div class="app">
						<div class="wrapper">
							<div class="left">
								<p class="title">APP OFICIAL PAYSANDU S.C.</p>

								<div class="stores">
									<a href="https://itunes.apple.com/br/app/paysandu-sc-oficial/id1078506718?l=en&mt=8" target="_blank" rel="noopener">
										<img src="/img/site/elements/items/apple.png" alt="app store">
									</a>
	
									<a href="https://play.google.com/store/apps/details?id=br.com.paysandu" target="_blank" rel="noopener">
										<img src="/img/site/elements/items/google.png" alt="google play">
									</a>
								</div>
							</div>
							
							<div class="right">
								<div class="mockup">
									<img src="/img/site/elements/items/mockup.png" alt="app">
								</div>
							</div>

						</div> <!-- end wrapper -->
					</div>
				</div>
			</div> <!-- end container -->
		</div> <!-- end layer-1 -->

		<div class="layer-2">
			<div class="container">
				<div class="flex-wrapper">
					<div class="contato-item">
						<p class="title">Sede Social</p>
						<p class="text">Av. Nazaré, 404</p>
						<p class="text">Nazaré. Belém - PA</p>
						<p class="phone">+55 (91) 3222-3763</p>
					</div>

					<div class="contato-item">
						<p class="title">Estádio da Curuzu</p>
						<p class="text">Av, Alm. Barroso, 654</p>
						<p class="text">Marco, Belém - PA</p>
						<p class="phone">+55 (91) 3246-8898</p>
					</div>

					<div class="contato-item">
						<p class="title">Hotel Antonio Couceiro</p>
						<p class="text">Av, Alm. Barroso, 654</p>
						<p class="text">Marco, Belém - PA</p>
						<p class="phone">+55 (91) 3246-8898</p>
					</div>

					<div class="contato-item">
						<p class="title">Sede Náutica</p>
						<p class="text">Tv. Dom Bôsco, 2</p>
						<p class="text">Cidade Velha, Belém - PA</p>
						<p class="phone">+55 (91) 3222-3763</p>
					</div>

					<div class="contato-item">
						<p class="title">CT Raul Aguilera</p>
						<p class="text">Av. Nazaré, 404</p>
						<p class="text">Nazaré. Belém - PA</p>
						<p class="phone">+55 (91) 3222-3763</p>
					</div>
				</div>
			</div> <!-- end container -->
		</div> <!-- end layer-2 -->

		<div class="layer-3">
			<div class="container">
				<div class="flex-wrapper">
					<div class="item">
						<span>&copy; {{ date('Y') }}</span>
					</div>

					<div class="item">
						<span>TODOS OS DIREITOS RESERVADOS PAYSANDU S.C.</span>
					</div>

					<div class="item">
						<a href="http://www.bredi.com.br/v3/" target="_blank" rel="noopener">
							FEITO POR <strong>BREDI</strong>
						</a>
					</div>
				</div>
			</div> <!-- end container -->
		</div> <!-- end layer-3 -->
	</footer>
		
	{{--  custom scripts  --}}
	<script type="text/javascript" src="/js/site/vendor.js"></script>
	<script type="text/javascript" src="/js/site/site.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/wow/1.1.2/wow.min.js"></script>
	<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCSbep-ywA8xBOiK9xriO6BwIMjkuljyv4&callback=initialize"></script>
	
	<!-- Lightbox2 -->
	{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.8.2/js/lightbox-plus-jquery.min.js"></script> --}}
	
	{{--  page scripts  --}}
	@yield('scripts')

	<script>
		if (navigator.platform.match('Mac') !== null) {
			document.body.setAttribute('class', 'OSX');
		}
	</script>

</body>
</html>