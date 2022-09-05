@section('title', 'Professores')
@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Professor</a></li>
    </ol>

    <h1 class="page-header">Professores</h1>

    <div class="row">
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">{{ isset($professor) ? 'Atualizar registro' : 'Novo registro' }}</h4>
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
                    @if (isset($professor->id))
                        {!! Form::model($professor, ['route' => ['controle.professor.update', $professor->id], 'method' => 'PUT']) !!}
                    @else
                        {!! Form::model(null, ['route' => 'controle.professor.store']) !!}
                    @endif


                    <div class="form-group">
                        <label for="nome">Nome*</label>
                        {!! Form::text('nome', null, ['class' => 'form-control', 'required']) !!}
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        {!! Form::text('email', null, ['class' => 'form-control']) !!}
                    </div>

                    <div class="form-group">
                        <label for="telefone">Telefone</label>
                        {!! Form::text('telefone', null, ['class' => 'form-control']) !!}
                    </div>

                    <button type="submit" class="btn btn-sm btn-primary m-r-5">Salvar</button>

                    <a href="{{ route('controle.professor.index') }}" class="btn btn-sm btn-default">Cancelar</a>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer>
        $(document).ready(function() {
            $('#timepicker').timepicker({
                modalBackdrop: true,
                maxHours: 24,
                showMeridian: false
            });

            $('#timepicker2').timepicker({
                modalBackdrop: true,
                maxHours: 24,
                showMeridian: false
            });
        });
    </script>
@endpush
