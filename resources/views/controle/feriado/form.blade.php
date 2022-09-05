@section('title', 'Feriados')
@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Feriados</a></li>
    </ol>

    <h1 class="page-header">Feriados</h1>

    <div class="row">
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ isset($feriado) ? 'Atualizar registro' : 'Novo registro' }}</h4>
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
                    @if (isset($feriado))
                        {!! Form::model($feriado, ['route' => ['controle.feriados.update', $feriado], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::model(null, ['route' => 'controle.feriados.store']) !!}
                    @endif



                    <div class="form-group">
                        <label for="nome">Nome*</label>
                        {!! Form::text('nome', null, ['class' => 'form-control', 'required']) !!}
                    </div>


                    <div class="form-group">
                        <label for="data">Data*</label>
                        {!! Form::date('data', null, ['class' => 'form-control']) !!}
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary m-r-5">Salvar</button>

                    <a href="{{ route('controle.feriados.index') }}" class="btn btn-sm btn-default">Cancelar</a>
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
