@section('title', 'Salas')
@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Sala</a></li>
    </ol>

    <h1 class="page-header">Salas</h1>

    <!-- begin form-filter -->
    <div class="col-lg-7">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <h4 class="panel-title">Filtrar</h4>
            </div>
            <div class="panel-body">

                {!! Form::model(isset($input) ? $input : null, ['route' => 'controle.salas.index', 'method' => 'get', 'id' => 'form-busca']) !!}
                <div class="d-flex flex-column mx-auto">
                    <div class="form-group row">
                        <div class="form-group col-md-6">
                            <label for="titulo">Titulo</label>
                            {!! Form::text('titulo', isset($_REQUEST['titulo']) ? $_REQUEST['titulo'] : null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="col-md-6">
                            <label for="bloco_id">Bloco</label>
                            {!! Form::select('bloco_id', count($blocos) > 0 ? [null => 'Todos os blocos'] + $blocos  : [null => 'Nenhum bloco cadastrado'], isset($bloco) ? [$bloco->titulo => $bloco->id] : null, ['class' => 'form-control']) !!}
                        </div>                        
                    </div>
                </div>

                <button type="button" class="btn btn-sm btn-default m-r-5 limpar">LIMPAR</button>
                <button type="submit" class="btn btn-sm btn-primary m-r-5 pull-right">BUSCAR</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Lista de Salas</h4>
                    <div class="panel-heading-btn">
                        <a href="{{ route('controle.salas.create') }}" class="btn btn-xs btn-circle2 btn-primary"><i
                                class="fa fa-plus"></i> Novo Registro</a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                            data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                            data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                            data-click="panel-remove"><i class="fa fa-times"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Meal">
                        <thead>
                            <tr>
                                <th>Titulo</th>
                                <th>Bloco</th>
                                <th>Label</th>
                                <th width="10%">Opções</>
                            </tr>
                        </thead>
                        @if (count($salas))
                            <tbody data-id="1" class="sortable">
                                @foreach ($salas as $sala)
                                    <tr data-id="{{ $sala->id }}" class="banner">

                                        <td>
                                            {{ $sala->titulo ?? '' }}
                                        </td>

                                        <td>
                                            {{ $sala->bloco->titulo ?? '' }}
                                        </td>

                                        <td>
                                            <div
                                                style="width:50px;height:50px;border:1px solid black;background-color: {{ $sala->backgroundColor ?? '' }};">

                                            </div>
                                        </td>

                                        <td>
                                            <a href="{{ route('controle.salas.edit', $sala) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                                Editar
                                            </a>

                                            <a href="javascript:void(0)" onclick="confirmaDelete({{ $sala->id }})"
                                                class="btn btn-danger btn-sm atencao">
                                                <i class="fa fa-trash-alt"></i>
                                                Excluir
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tr data-id="empty">
                                <td colspan="7" class="text-center text-muted p-t-30 p-b-30">
                                    <div class="m-b-10"><i class="fa fa-file fa-3x"></i></div>
                                    <div>Sem registros</div>
                                </td>
                            </tr>
                        @endif
                    </table>
                    {!! $salas->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer>
        const confirmaDelete = (id) => {
            Swal.fire({
                    title: 'Deseja deletar esta sala?',
                    text: "Esta ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#0062cc',
                    confirmButtonText: 'Sim, deletar!',
                    cancelButtonText: 'Não, cancelar!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        axios.delete(
                            "{{ route('controle.salas.delete') }}", {
                                data: {
                                    id: id
                                }
                            }).then(response => {
                            if (response.status == 204) {
                                Swal.fire(
                                    'Deletado!',
                                    'Operação realizada com sucesso.',
                                    'success'
                                )
                                window.location.reload()
                            }
                        })
                    }
                })
        }
        $(document).ready(function() {});
    </script>
@endpush
