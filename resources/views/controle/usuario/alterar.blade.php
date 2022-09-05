@section('title', 'Alterar administrador')
@extends('layouts.default')

@section('content')

@push('css')
	<link href="/assets/css/default/invoice-print.min.css" rel="stylesheet" />
@endpush

	<ol class="breadcrumb hidden-print float-xl-right">
		<li class="breadcrumb-item"><a href="{{ route('usuario.index') }}">Usuário</a></li>
		<li class="breadcrumb-item active">Cadastrar</li>
	</ol>

    <h1 class="page-header">Editar Usuário</h1>

<div class="invoice">

    <div class="invoice-header">
        <div class="invoice-from">
            <address class="m-t-5 m-b-5">
                <div class="panel-body">
                    @include('controle.includes.alert.mensagem')

                    <form method="POST" action="">
                        @csrf
                        <div class="form-group m-l-10 m-t-10">
                            <div class="form-group" style="width: 50%;">
                                <label>Nome</label>
                                <input class="form-control" type="text" placeholder="Nome" aria-label="Digite seu nome" name="name" value="{{$user->name}}">
                            </div>

                            <div class="form-group" style="width: 50%;">
                                <label>Email</label>
                                <input class="form-control" type="email" placeholder="Email" aria-label="Digite seu email" name="email" value="{{$user->email}}">                       
                            </div>

                            <div class="form-group" style="width: 50%;">
                                <label>Alterar Senha</label> 
                                <input class="form-control" type="password" placeholder="Senha" aria-label="Alterar sua senha" name="password">       
                            </div>

                            <div class="box-footer">
                                <a class="btn btn-info" href="{{route('usuario.index')}}">Voltar</a>
                                <button type="submit" class="btn btn-success">Alterar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </address>
        </div>
    </div>
</div>

@endsection
