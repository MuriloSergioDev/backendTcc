
@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    {{-- @component('bredicoloradmin::components.migalha')
        <li class="breadcrumb-item"><a href="{{ route('controle.config.edit') }}">Configurações</a></li>
    @endcomponent --}}
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header">Configurações</h1>
    <!-- end page-header -->
    <div class="row">
        <div class="col-lg-6">
            <!-- begin panel -->
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Atualização das configurações</h4>
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
                    @include('controle.includes.alert.mensagem')
                    {!! Form::model($config,['route' => 'controle.config.update', 'files' => true]) !!}
                        <fieldset>
                            <div class="form-group">
                                <label for="nome">Nome do projeto</label>
                                {!! Form::text('nome', null, ['class' => 'form-control', 'required']) !!}
                            </div>
                            <div class="form-group">
                                <label for="logo">Logo da empresa</label>
                                @if(isset($config->config['layout']['logo']))
                                <div class="col-sm-4">
                                    <img src="{{ route('imagem.render', "company/p/". $config->config['layout']['logo']) }}" alt="" class="img-fluid">
                                </div>
                                @endif
                                {!! Form::file("logo", ['class' => 'form-control']) !!}
                            </div>
                            <div class="form-group">
                                <label for="background_image">Background Login</label>
                                @if(isset($config->config['layout']['background_image']))
                                <div class="col-sm-4">
                                    <img src="{{ route('imagem.render', "background_image/". $config->config['layout']['background_image']) }}" alt="" class="img-fluid">
                                </div>
                                @endif
                                {!! Form::file("background_image", ['class' => 'form-control']) !!}
                            </div>
                            
                            @can('controle.config.update')
                                <button type="submit" class="btn btn-lg btn-primary m-r-5"><i class="fa fa-save"></i> Salvar</button>
                            @endcan
                        </fieldset>
                    {!! Form::close() !!}
                    <br>

                </div> <!-- panel-body -->
                
            </div>
            <!-- end panel -->

        </div>
    </div>
    
@stop
