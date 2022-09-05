@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb pull-right">
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">
        Usuário
    </h1>
    <!-- end page-header -->

    <div class="row">
        <div class="col-lg-6">
            <!-- begin panel -->
            <div class="panel panel-inverse" data-sortable-id="form-stuff-9">
                <!-- begin panel-heading -->
                <div class="panel-heading">
                    <h4 class="panel-title">Usuário</h4>
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
                <!-- end panel-heading -->

                <!-- begin panel-body -->
                <div class="panel-body">
                    {!! Form::model(isset($user) ? $user : null,['route' => (isset($user->id) ? ['controle.profile.update', $user->id] : 'controle.profile.store'),'files' => true ]) !!}
                        <fieldset>
                            {{--  <legend class="m-b-15">Legend</legend>  --}}
                            <div class="form-group">
                                <label>Foto</label>
                                @if(!empty($user->imagem))
                                <div>
                                    <img src="{{ route('imagem.render', 'user/p/' . $user->imagem) }}" alt="" class="img-fluid">
                                </div>
                                @endif
                                {!! Form::file('imagem', ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>Nome</label>
                                {!! Form::text('name', null, ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label>E-mail</label>
                                {!! Form::email('email', null, ['class' => 'form-control']) !!}
                            </div>
                            <hr>
                            <div class="form-group">
                                <label>Alterar Senha</label>
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Nova senha']) !!}
                            </div>
                            <div class="form-group">
                                <label>Informe a senha atual</label>
                                {!! Form::password('actual_password', ['class' => 'form-control', 'placeholder' => 'Senha atual']) !!}
                            </div>
                            <button type="submit" class="btn btn-sm btn-primary m-r-5">Salvar</button>
                        </fieldset>
                    {!! Form::close() !!}
                </div>
                <!-- end panel-body -->
            </div>
            <!-- end panel -->
        </div>
    </div>

@stop
