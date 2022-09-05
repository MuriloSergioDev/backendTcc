@section('title', 'Blocos')
@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Blocos</a></li>
    </ol>

    <h1 class="page-header">Blocos</h1>

    <div class="row">
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ isset($bloco) ? 'Atualizar registro' : 'Novo registro' }}</h4>
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
                    @if (isset($bloco))
                        {!! Form::model($bloco, ['route' => ['controle.bloco.update', $bloco], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::model(null, ['route' => 'controle.bloco.store']) !!}
                    @endif


                    <div class="col-xl-7">
                        <div class="form-group">
                            <label for="titulo">Titulo*</label>
                            {!! Form::text('titulo', null, ['class' => 'form-control', 'required']) !!}
                        </div>
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary m-r-5">Salvar</button>

                    <a href="{{ route('controle.bloco.index') }}" class="btn btn-sm btn-default">Cancelar</a>
                    {!! Form::close() !!}
                </div>



            </div>
        </div>
    </div>
    </div>
@endsection

@push('scripts')
    <script defer>
    </script>
@endpush
