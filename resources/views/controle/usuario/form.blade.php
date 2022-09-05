@section('title', 'Cadastrar Usuários')
@extends('layouts.default')

@section('content')
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Cadastrar Usuários</a></li>
    </ol>

    <h1 class="page-header">Usuários</h1>

    <div class="row">
        <div style="width: 100vw">

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">{{isset($user) ? 'Atualização de Usuários' : 'Cadastro de Usuários'}}</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success"
                            data-click="panel-reload"><i class="fa fa-redo"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                            data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>

                <div class="panel-body">
                    {{ $msg ?? '' }}
                    @include('controle.includes.alert.mensagem')

                    @if (isset($user->id))
                        {!! Form::model($user, ['route' => ['controle.usuario.update', $user->id]]) !!}
                    @else
                        {!! Form::model(null, ['route' => 'controle.usuario.store']) !!}
                    @endif
                    <fieldset>

                        <div class="form-group w-75">
                            <label for="roles">Grupo Usuário</label>
                            {!! Form::select('roles', $roles ? [null=>'Selecione'] + $roles : [null=>'Nenhuma grupo cadastrado'] , isset($user) ? $user->roles->first()->name : null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group w-75">
                            <label for="name">Nome</label>
                            {!! Form::text('name', null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        <div class="form-group w-75">
                            <label for="email">Email</label>
                            {!! Form::text('email', null, ['class' => 'form-control', 'required']) !!}
                        </div>

                        @if (isset($user->id))

                        <div class="form-group w-75">
                            <label>Senha ( Deixe em branco caso não deseje alterar )</label>
                            <input type="password" name="password" class="form-control">
                        </div>

                        <div class="form-group w-75">
                            <label>Confirmar a senha</label>
                            <input type="password" name="password_confirmation" class="form-control">
                        </div>

                        @else

                        <div class="form-group w-75">
                            <label>Senha</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group w-75">
                            <label>Confirmar a senha</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        @endif

                        <button type="submit" class="btn btn-sm btn-primary m-r-5">Salvar</button>

                        <a href="{{ route('controle.usuario.index') }}" class="btn btn-sm btn-default">Cancelar</a>
                    </fieldset>
                    {!! Form::close() !!}

                </div> <!-- panel-body -->

            </div>

        </div>
    </div>
@endsection
