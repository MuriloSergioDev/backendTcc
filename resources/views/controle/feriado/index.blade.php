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
                    <h4 class="panel-title">Lista de Feriados</h4>
                    <div class="panel-heading-btn">
                        <a href="{{ route('controle.feriados.create') }}" class="btn btn-xs btn-circle2 btn-primary"><i
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
                                <th>Nome</th>
                                <th>Data</th>
                                <th width="10%">Opções</th>
                            </tr>
                        </thead>
                        @if (count($feriados))
                            <tbody data-id="1" class="sortable">
                                @foreach ($feriados as $feriado)
                                    <tr data-id="{{ $feriado->id }}" class="banner">

                                        <td>
                                            {{ $feriado->nome ?? '' }}
                                        </td>

                                        <td>
                                            {{ $feriado->data ?? '' }}
                                        </td>

                                        <td>
                                            <a href="{{ route('controle.feriados.edit', $feriado) }}"
                                                class="btn btn-primary btn-sm">
                                                <i class="fa fa-edit"></i>
                                                Editar
                                            </a>

                                            <a href="javascript:void(0)" onclick="confirmaDelete({{ $feriado->id }})"
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
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script defer>
        const confirmaDelete = (id) => {
            Swal.fire({
                    title: 'Deseja deletar este feriado?',
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
                            "{{ route('controle.feriados.delete') }}", {
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
