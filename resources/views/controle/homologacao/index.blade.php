@section('title', 'Homologação')
@extends('layouts.default')

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Homologação</a></li>
    </ol>

    <h1 class="page-header">Homologação</h1>

    <div class="row">
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Lista de Homologação</h4>
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
                    <table class=" table table-bordered table-striped table-hover datatable datatable-Meal">
                        <thead>
                            <tr>
                                <th>Evento</th>
                                <th>Descrição</th>
                                <th>Professor</th>
                                <th>Sala</th>
                                <th>Data</th>
                                <th>Horário</th>
                                <th>Público Alvo</th>
                                <th>Quantidade de pessoas</th>
                                <th width="10%">Opções</th>
                            </tr>
                        </thead>
                        @if (count($eventos))
                            <tbody data-id="1" class="sortable">
                                @foreach ($eventos as $evento)
                                    <tr data-id="{{ $evento->id }}" class="banner">

                                        <td>
                                            {{ $evento->title ?? '' }}
                                        </td>

                                        <td>
                                            {{ $evento->description ?? '' }}
                                        </td>

                                        <td>
                                            {{ $evento->professor->nome ?? '' }}
                                        </td>

                                        <td>
                                            {{ $evento->sala->titulo ?? '' }}
                                        </td>

                                        <td>
                                            {{ $evento->getDataStart() ?? '' }}
                                        </td>

                                        <td>
                                            {{ $evento->getTimeStart() . ' ás ' . $evento->getTimeEnd() }}
                                        </td>

                                        <td>{{ $evento->publico_alvo ?? '' }}</td>

                                        <td>{{ $evento->quantidade_pessoas ?? '' }}</td>

                                        <td>
                                            <a href="javascript:void(0)" onclick="confirmaDeferir({{ $evento->id }})"
                                                class="btn btn-success btn-sm atencao">
                                                <i class="fas fa-check"></i>
                                                Deferir
                                            </a>

                                            <a href="javascript:void(0)" onclick="confirmaIndeferir({{ $evento->id }})"
                                                class="btn btn-danger btn-sm atencao">
                                                <i class="fas fa-times"></i>
                                                Indeferir
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
        const confirmaIndeferir = (id) => {
            Swal.fire({
                    title: 'Deseja indeferir esse evento?',
                    text: "Esta ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#0062cc',
                    confirmButtonText: 'Sim, indeferir!',
                    cancelButtonText: 'Não, cancelar!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $('body').loadingModal({
                            text: 'Carregando...'
                        });
                        axios.put(
                            "{{ route('controle.homologacao.indeferir') }}", {
                                id: id
                            }).then(response => {
                            $('body').loadingModal('destroy');
                            if (response.status == 204) {
                                Swal.fire(
                                    'Evento indeferido!',
                                    'Operação realizada com sucesso.',
                                    'success'
                                ).then((res) =>{
                                    if (res.isConfirmed) {
                                        window.location.reload()    
                                    }
                                })
                                
                            }
                        })
                    }
                })
        }

        const confirmaDeferir = (id) => {
            Swal.fire({
                    title: 'Deseja deferir esse evento?',
                    text: "Esta ação não poderá ser desfeita!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#0062cc',
                    confirmButtonText: 'Sim, deferir!',
                    cancelButtonText: 'Não, cancelar!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        $('body').loadingModal({
                            text: 'Carregando...'
                        });
                        axios.put(
                            "{{ route('controle.homologacao.deferir') }}", {
                                id: id
                            }).then(response => {
                            $('body').loadingModal('destroy');
                            if (response.status == 204) {
                                Swal.fire(
                                    'Evento deferido!',
                                    'Operação realizada com sucesso.',
                                    'success'
                                ).then((res) =>{
                                    if (res.isConfirmed) {
                                        window.location.reload()    
                                    }
                                })                    
                            }
                        })
                    }
                })
        }
        $(document).ready(function() {});
    </script>
@endpush
