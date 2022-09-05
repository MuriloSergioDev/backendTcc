@extends('layouts.empty', ['paceTop' => true, 'bodyExtraClass' => 'bg-white'])

@section('title', 'Login Page')

@section('content')
	<!-- begin login -->
	<div class="login login-with-news-feed">
		<!-- begin news-feed -->
		<div class="news-feed">
			<div class="news-image text-white"
			style="background-image: url({{ asset('storage/background_image/'.$config->config['layout']['background_image']) }})">
			</div>
			<div class="news-caption">
				<h4 class="caption-title"><b>Painel</b> Administrativo</h4>
				<p>
					Bem vindo(a) ao seu painel administrativo.
				</p>
			</div>
		</div>
		<!-- end news-feed -->
		<!-- begin right-content -->
		<div class="right-content">
			<!-- begin login-header -->
			<div class="login-header">
				<div class="brand">
					<b>{{ $config->nome }}</b> - Controle
					{{-- <small>Administre com fluidez e velocidade</small> --}}
				</div>
				<div class="icon">
					@if (isset($config->config['layout']['logo']))
					<small style="width: 70px" class="logo"><img src="{{ route('imagem.render', "company/p/". $config->config['layout']['logo']) }}" alt="" class="img-fluid"></small>
					@else
					<i class="fa fa-sign-in-alt"></i>
					@endif
				</div>
			</div>
			<!-- end login-header -->
			<!-- begin login-content -->
			<div class="login-content">

				<x-jet-validation-errors class="mb-4" class="alert alert-danger" />

				<form action="{{ route('controle.login') }}" method="POST" class="margin-bottom-0">
                    @csrf
					<div class="form-group m-b-15">
						<input type="text" name="email" class="form-control form-control-lg" value="" placeholder="Email" data-parsley-required="true" />
					</div>
					<div class="form-group m-b-15">
						<input type="password" name="password" class="form-control form-control-lg" value="" placeholder="Senha" required />
					</div>
					<div class="checkbox checkbox-css m-b-30">
						<input type="checkbox" id="remember_me_checkbox" value="" name="remember"/>
						<label for="remember_me_checkbox">
						Relembre-me
						</label>
					</div>
					<div class="login-buttons">
						<button type="submit" class="btn btn-warning btn-block btn-lg">Entrar</button>
					</div>
					<hr />
					<p class="text-center text-grey-darker mb-0">
						&copy; Painel Administrativo todos os direitos reservados 2021
					</p>
				</form>
			</div>
			<!-- end login-content -->
		</div>
		<!-- end right-container -->
	</div>
	<!-- end login -->
	<script type="text/javascript">
		document.addEventListener("DOMContentLoaded", function(event) {
			history.pushState(null, null, document.URL);
				window.addEventListener('popstate', function () {
				history.pushState(null, null, document.URL);
				location.reload();
			});
		});
	</script>
@endsection
