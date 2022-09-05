@section('title', 'Salas')
@extends('layouts.default')

@push('css')
    <link href="/assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Sala</a></li>
    </ol>

    <h1 class="page-header">Salas</h1>

    <div class="row">
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ isset($sala) ? 'Atualizar registro' : 'Novo registro' }}</h4>
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                            data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    @if (isset($sala))
                        {!! Form::model($sala, ['route' => ['controle.salas.update', $sala], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::model(null, ['route' => 'controle.salas.store']) !!}
                    @endif

                    <div class="form-group row ">
                        <div id="cp2" class="col-md-1">
                            <label for="backgroundColor">Label</label>
                            <input name="backgroundColor" type="hidden" value="{{isset($sala) ? $sala->backgroundColor : '#DD0F20FF'}}" />
                            <span class="input-group-append">
                                <span class="input-group-text colorpicker-input-addon"><i></i></span>
                            </span>
                        </div>

                        <div class="col-md-11">
                            <label for="bloco_id">Bloco</label>
                            {!! Form::select('bloco_id', count($blocos) > 0 ? $blocos : [null => 'Nenhum bloco cadastrado'], null, ['class' => 'form-control', 'required']) !!}
                        </div>

                    </div>

                    <div class="form-group">
                        <label for="titulo">Titulo*</label>
                        {!! Form::text('titulo', null, ['class' => 'form-control', 'required']) !!}
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary m-r-5">Salvar</button>

                    <a href="{{ route('controle.salas.index') }}" class="btn btn-sm btn-default">Cancelar</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script defer>
        $(document).ready(function() {
            $('#cp2').colorpicker();
        });
    </script>
@endpush
