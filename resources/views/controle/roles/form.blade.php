@extends('layouts.default')

@section('content')

    <h1 class="page-header">Grupo de Usuários</h1>

    <div class="row">
        <div style="width: 100vw">

            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        {{ isset($role) ? 'Atualização de Grupo de Usuários' : 'Cadastro de Grupo de Usuários' }}</h4>
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
                    @if (isset($role))
                        {!! Form::model($role, ['method' => 'post', 'route' => ['controle.roles.update', $role->id]]) !!}
                    @else
                        {!! Form::model(null, ['route' => 'controle.roles.store']) !!}
                    @endif
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Nome:</strong>
                                {!! Form::text('name', null, ['placeholder' => 'Nome', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="data_inicio">Data Inicio Edição</label>
                                {!! Form::date('data_inicio', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <label for="data_fim">Data Fim Edição</label>
                                {!! Form::date('data_fim', null, ['class' => 'form-control']) !!}
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group row ">
                                <div class="col-md-9">
                                    <label for="sala_id">Salas de homologação</label>
                                    {!! Form::select('sala_id', isset($salas) ? $salas : [null => 'Nenhuma sala cadastrada'], null, ['class' => 'form-control novasala select2', 'required', 'id' => 'sala_id_create']) !!}
                                </div>
                                <div class="col-md-3 mt-4">
                                    <button class="btn btn-primary" type="button" id="btnAddSala">Adicionar</button>
                                </div>
                            </div>
                        </div>
                        <div class="abaSalas w-100">
                            @if (isset($grupoSalas))                                                        
                            @foreach ($grupoSalas as $grupoSala)
                                <div class="col-xs-12 col-sm-12 col-md-12">
                                    <div id="{{$grupoSala->sala->id}}"
                                        class="bg-light row d-flex justify-content-center p-10 border border-white">
                                        <input type="hidden" name="sala_id[]" readonly class="form-control-plaintext"
                                            value="{{$grupoSala->sala->id}}" />
                                        <div class="d-flex justify-content-between align-items-center w-100">
                                            <h5>{!!$grupoSala->sala->titulo!!}</h5>
                                            <i class="fas fa-times fa-2x" style="cursor: pointer"
                                                onclick="removeSala({{$grupoSala->sala->id}})"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @endif
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Permissões:</strong>
                                <br />
                                @if (isset($role))
                                    @foreach ($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, in_array($value->id, $rolePermissions) ? true : false, ['class' => 'name']) }}
                                            {{ $value->name }}</label>
                                        <br />
                                    @endforeach
                                @else
                                    @foreach ($permission as $value)
                                        <label>{{ Form::checkbox('permission[]', $value->id, false, ['class' => 'name']) }}
                                            {{ $value->name }}</label>
                                        <br />
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <button type="submit" class="btn btn-sm btn-primary m-r-5">Salvar</button>
                            <a href="{{ route('controle.roles.index') }}" class="btn btn-sm btn-default">Cancelar</a>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div> <!-- panel-body -->

            </div>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $(".select2").select2();
        });
    </script>
    <script>
        document.getElementById("btnAddSala").addEventListener("click", function(event) {
            id = document.querySelector('.novasala').value;
            const abaSalas = document.querySelector('.abaSalas');
            const sala = document.getElementById(id);

            if (!sala) {
                axios.get(`/api/sala/${id}`)
                    .then(res => {
                        html = `
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <div id="${res.data.sala.id}" class="bg-light row d-flex justify-content-center p-10 border border-white">
                                    <input type="hidden" name="sala_id[]" readonly class="form-control-plaintext"
                                    value="${res.data.sala.id}" />
                                    <div class="d-flex justify-content-between align-items-center w-100">
                                        <h5>${res.data.sala.titulo}</h5>
                                        <i class="fas fa-times fa-2x" style="cursor: pointer" onclick="removeSala('${res.data.id}')"></i>
                                    </div>
                                </div>
                            </div>
                                `

                        abaSalas.insertAdjacentHTML('beforeend', html)
                    })
                    .catch(err => {
                        // console.error(err);
                        Swal.fire({
                            title: 'Sala não encontrada',
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        })
                    })
            }
        })

        const removeSala = (id) => {
            Swal.fire({
                    title: 'Deseja remover esta sala?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#0062cc',
                    confirmButtonText: 'Sim, remover!',
                    cancelButtonText: 'Não, cancelar!'
                })
                .then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById(id).remove()
                        contadorClientes--;
                    }
                })
        }
    </script>
@endpush
