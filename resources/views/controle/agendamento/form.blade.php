@section('title', 'Agendamentos')
@extends('layouts.default')

@push('css')
    <style>
        .box-container {
            display: flex;
            flex-direction: row;
            flex-wrap: wrap;
        }

        .box-evento {
            margin: 1rem;
            width: 15rem;
            height: 150px;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            transition: 0.3s;
            border-radius: 5px;
        }

        .box-evento:hover {
            opacity: 0.7;
            cursor: pointer;
            box-shadow: 0 8px 16px 0 rgba(0, 0, 0, 0.2);
        }

        .box-evento-header {
            background-color: black;
            color: white;
            width: 100%;
            padding: 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            border-radius: 5px 5px 0px 0px;
        }

        .box-evento-body {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            width: 100%;
            height: 100%;
        }

        .modal {
            overflow-y: auto;
        }

        .modal.show::-webkit-scrollbar {
            display: none;
        }

        .abaHorarios {
            display: flex;
            flex-direction: row !important;
            justify-content: center;
            flex-wrap: wrap;
        }

        .horario-card {
            cursor: pointer;
            width: 160px;
        }

        .horario-card:hover {
            opacity: 0.7 !important;
        }

    </style>
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Agendamento</a></li>
    </ol>

    <h1 class="page-header">Agendamentos</h1>


    <div class="row">
        @if (isset($eventos))
            <div class="row">
                <div style="width: 100vw">
                    <div class="panel panel-inverse">
                        <div class="panel-heading">
                            <h4 class="panel-title">Eventos</h4>
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

                            <div class="box-container">
                                @foreach ($eventos as $evento)
                                    <div class="box-evento" onclick="eventClick({{ $evento->id }})"
                                        style="background-color: #9bf285;">
                                        <div class="box-evento-header">
                                            <h4>{{ $evento->title }}</h4>
                                            @if ($evento->status_id = 1)                                                
                                                <h4>(Em homologação)</h4>
                                            @elseif ($evento->status_id = 3)
                                                <h4>(Indeferido)</h4>
                                            @endif                                            
                                        </div>

                                        <div class="box-evento-body">
                                            <h5>({{ $evento->getTimeStart() }} - {{ $evento->getTimeEnd() }})</h5>
                                            <h5>Bloco: {{ $evento->bloco->titulo }} - Sala: {{ $evento->sala->titulo }}</h5>
                                            <h5>{{ date('d-m-Y' , strtotime($evento->getDataStart())) }}</h5>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        @endif
        <div style="width: 100vw">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Lista de Agendamentos</h4>
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
                    <div class="col-xl-10">

                        @if (isset($agendamento))
                            {!! Form::model($agendamento, ['route' => 'controle.agendamentos.update', 'id' => 'form']) !!}
                        @else
                            {!! Form::model(null, ['route' => 'controle.agendamentos.store.recorrente', 'method' => 'POST', 'id' => 'form']) !!}
                        @endif

                        <h4 class="text-dark">Informações básicas</h4>

                        @if (isset($agendamento))
                            <div class="form-group">
                                <label for="alterar_antigos">Deseja alterar os eventos já registrados?</label>
                                {!! Form::select('alterar_antigos', [false => 'Não, apenas adicionar novos'] + [true => 'Sim, alterar eventos existentes'], null, ['class' => 'form-control', 'required', 'id' => 'alterar_antigos']) !!}
                            </div>
                        @endif

                        <div class="form-group">
                            <label for="bloco_id">Bloco*</label>
                            {!! Form::select('bloco_id', count($blocos) ? [null => 'Selecione um bloco'] + $blocos : [null => 'Nenhuma bloco cadastrado'], null, ['class' => 'form-control required', 'required', 'id' => 'bloco']) !!}
                        </div>

                        <div class="form-group">
                            <label for="tipo_id">Tipo*</label>
                            {!! Form::select('tipo_id', count($tipos) ? [null => 'Selecione um tipo'] + $tipos : [null => 'Nenhum tipo cadastrado'], null, ['class' => 'form-control required', 'required', 'id' => 'tipo']) !!}
                        </div>

                        <div class="form-group">
                            <label for="title">Título*</label>
                            {!! Form::text('title', null, ['class' => 'form-control required', 'required']) !!}
                        </div>

                        <div class="form-group">
                            <label for="description">Descrição</label>
                            {!! Form::textarea('description', null, ['class' => 'form-control']) !!}
                        </div>

                        <div class="form-group">
                            <label for="sala_id">Sala*</label>
                            {!! Form::select('sala_id', [null => 'Selecione um bloco'], null, ['class' => 'form-control', 'required', 'id' => 'salas']) !!}
                        </div>

                        <div class="form-group">
                            <label for="professor_id">Professor*</label>
                            {!! Form::select('professor_id', isset($professores) ? $professores : [null => 'Nenhum professor cadastrado'], null, ['class' => 'form-control select2', 'required', 'id' => 'professores']) !!}
                        </div>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label>Quantidade de pessoas</label>
                                <input type="number" name="quantidade_pessoas" class="form-control" required min="1" value="1">
                            </div>
                            <div class="col-md-6">
                                <label>Público Alvo*</label>
                                <input type="text" name="publico_alvo" class="form-control required" required/>
                            </div>
                        </div>

                        <h4 class="text-dark">Periodo</h4>

                        <div class="form-group row">
                            <div class="col-md-6">
                                <label for="data_inicio">Data de Inicio*</label>
                                {!! Form::date('data_inicio', isset($agendamento) ? $agendamento->getDataStart() : null, ['class' => 'form-control data_inicio']) !!}
                            </div>

                            <div class="col-md-6">
                                <label for="data_fim">Data de Fim*</label>
                                {!! Form::date('data_fim', isset($agendamento) ? $agendamento->getDataEnd() : null, ['class' => 'form-control data_fim']) !!}
                            </div>
                        </div>                        

                        <h4 class="text-dark">Dias da semana</h4>

                        <div class="form-group row d-flex align-items-end">
                            <div class="col-md-3">
                                <div class=" checkbox checkbox-css m-b-20">
                                    <div class="form-check m-r-10">
                                        {!! Form::checkbox('dia_semana[]', 1, null, ['class' => 'form-check-input', 'id' => 'segunda', 'onchange' => 'toggleData(this,1)']) !!}
                                        <label class="form-check-label" for="segunda">Segunda-feira</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="horario[1]">
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Inicial</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_inicial_1" id="horario_inicial_1" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Final</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_final_1" id="horario_final_1" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-end">
                            <div class="col-md-3">
                                <div class=" checkbox checkbox-css m-b-20">
                                    <div class="form-check m-r-10">
                                        {!! Form::checkbox('dia_semana[]', 2, null, ['class' => 'form-check-input', 'id' => 'terca', 'onchange' => 'toggleData(this,2)']) !!}
                                        <label class="form-check-label" for="terca">Terça-feira</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="horario[2]">
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Inicial</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_inicial_2" id="horario_inicial_2" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Final</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_final_2" id="horario_final_2" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-end">
                            <div class="col-md-3">
                                <div class=" checkbox checkbox-css m-b-20">
                                    <div class="form-check m-r-10">
                                        {!! Form::checkbox('dia_semana[]', 3, null, ['class' => 'form-check-input', 'id' => 'quarta', 'onchange' => 'toggleData(this,3)']) !!}
                                        <label class="form-check-label" for="quarta">Quarta-feira</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="horario[3]">
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Inicial</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_inicial_3" id="horario_inicial_3" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Final</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_final_3" id="horario_final_3" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-end">
                            <div class="col-md-3">
                                <div class=" checkbox checkbox-css m-b-20">
                                    <div class="form-check m-r-10">
                                        {!! Form::checkbox('dia_semana[]', 4, null, ['class' => 'form-check-input', 'id' => 'quinta', 'onchange' => 'toggleData(this,4)']) !!}
                                        <label class="form-check-label" for="quinta">Quinta-feira</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="horario[4]">
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Inicial</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_inicial_4" id="horario_inicial_4" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Final</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_final_4" id="horario_final_4" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-end">
                            <div class="col-md-3">
                                <div class=" checkbox checkbox-css m-b-20">
                                    <div class="form-check m-r-10">
                                        {!! Form::checkbox('dia_semana[]', 5, null, ['class' => 'form-check-input', 'id' => 'sexta', 'onchange' => 'toggleData(this,5)']) !!}
                                        <label class="form-check-label" for="sexta">Sexta-feira</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="horario[5]">
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Inicial</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_inicial_5" id="horario_inicial_5" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Final</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_final_5" id="horario_final_5" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-end">
                            <div class="col-md-3">
                                <div class=" checkbox checkbox-css m-b-20">
                                    <div class="form-check m-r-10">
                                        {!! Form::checkbox('dia_semana[]', 6, null, ['class' => 'form-check-input', 'id' => 'sabado', 'onchange' => 'toggleData(this,6)']) !!}
                                        <label class="form-check-label" for="sabado">Sabado</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="horario[6]">
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Inicial</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_inicial_6" id="horario_inicial_6" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Final</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_final_6" id="horario_final_6" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row d-flex align-items-end">
                            <div class="col-md-3">
                                <div class=" checkbox checkbox-css m-b-20">
                                    <div class="form-check m-r-10">
                                        {!! Form::checkbox('dia_semana[]', 7, null, ['class' => 'form-check-input', 'id' => 'domingo', 'onchange' => 'toggleData(this,7)']) !!}
                                        <label class="form-check-label" for="domingo">Domingo</label>
                                    </div>
                                </div>
                            </div>

                            <div class="d-none" id="horario[7]">
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Inicial</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_inicial_7" id="horario_inicial_7" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label">Horário Final</label>
                                    <div>
                                        <div class="input-group bootstrap-timepicker">
                                            <input name="horario_final_7" id="horario_final_7" type="text"
                                                class="form-control" />
                                            <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" id="btnEnviaForm" class="btn btn-sm btn-primary m-r-5">Confirmar</button>

                        <a href="{{ route('controle.agendamentos.index') }}" class="btn btn-sm btn-default">Cancelar</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>        
    </div>

    <div class="modal" tabindex="-1" role="dialog" id="form-calendar-update">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Alterar agendamento</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {!! Form::model(null, ['route' => 'controle.agendamentos.update', 'id' => 'formUpdate']) !!}

                    {!! Form::hidden('id', null, ['class' => 'form-control id']) !!}

                    {!! Form::hidden('bloco_id', null, ['class' => 'form-control', 'id' => 'bloco_id']) !!}

                    <div class="form-group">
                        <label for="tipo_id">Tipo*</label>
                        {!! Form::select('tipo_id', count($tipos) ? [null => 'Selecione um tipo'] + $tipos : [null => 'Nenhuma tipo cadastrado'], null, ['class' => 'form-control tipo required', 'required', 'id' => 'tipo2']) !!}
                        <div class="invalid-feedback">
                            <p>Este campo é obrigatório</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="title">Título*</label>
                        {!! Form::text('title', null, ['class' => 'form-control title required', 'required']) !!}
                        <div class="invalid-feedback">
                            <p>Este campo é obrigatório</p>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Descrição</label>
                        {!! Form::textarea('description', null, ['class' => 'form-control description']) !!}
                    </div>

                    <div class="form-group">
                        <label for="professor_id">Professor</label>
                        {!! Form::select('professor_id', isset($professores) ? $professores : [null => 'Nenhum professor cadastrado'], null, ['class' => 'form-control professor select2', 'required', 'id' => 'professor_id']) !!}
                    </div>

                    <div class="form-group row">

                        <div class="col-md-6">
                            <label for="sala_id">Sala*</label>
                            {!! Form::select('sala_id', [null => 'Selecione uma sala'], null, ['class' => 'form-control sala required', 'required', 'id' => 'sala_id']) !!}
                            <div class="invalid-feedback">
                                <p>Este campo é obrigatório</p>
                            </div>
                        </div>


                        <div class="col-md-6">
                            <label for="data_inicio">Data*</label>
                            {!! Form::date('data_inicio', null, ['class' => 'form-control start']) !!}
                            <div class="invalid-feedback">
                                <p>Este campo é obrigatório</p>
                            </div>
                        </div>

                        {!! Form::hidden('data_fim', null, ['class' => 'form-control data_fim']) !!}
                    </div>

                    <div class="form-group row">
                        <div class="col-md-6">
                            <label class="col-form-label">Horário Inicial</label>
                            <div>
                                <div class="input-group bootstrap-timepicker">
                                    <input name="horario_inicial" id="timepicker" type="text" class="form-control horario_inicial" />
                                    <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label class="col-form-label">Horário Final</label>
                            <div>
                                <div class="input-group bootstrap-timepicker">
                                    <input name="horario_final" id="timepicker2" type="text" class="form-control horario_final" />
                                    <span class="input-group-addon"><i class="fa fa-clock"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" id="btnDelete">Remover</button>
                        <button type="button" class="btn btn-primary" id="btnUpdate">Salvar</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
    <script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>
    <script>
        let requisicao_em_andamento = 0

        document.getElementById("btnDelete").addEventListener("click", function(event) {

            let formulario = document.getElementById('formUpdate')
            const dados = new FormData(formulario)

            Swal.fire({
                    title: 'Deseja deletar este agendamento?',
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
                        console.log(dados.get('id'));
                        axios.delete(
                            "{{ route('controle.agendamentos.delete.evento') }}", {
                                data: {
                                    id: dados.get('id')
                                }
                            }).then(response => {
                            if (response.status == 204) {
                                Swal.fire(
                                        'Deletado!',
                                        'Operação realizada com sucesso.',
                                        'success'
                                    )
                                    .then((result) => {
                                        if (result.isConfirmed || result.isDismissed) {
                                            window.location.reload()
                                        }
                                    })
                            }
                        })
                    }
                })
        })
    </script>
    <script>
        function formataData(data) {
            data = new Date(data);
            var day = ["Domingo", "Segunda-feira", "Terça-feira", "Quarta-feira", "Quinta-feira", "Sexta-feira", "Sábado"][
                data.getDay()
            ];
            var date = data.getDate();
            var month = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho", "Julho", "Agosto", "Setembro",
                "Outubro", "Novembro", "Dezembro"
            ][data.getMonth()];
            var year = data.getFullYear();

            return `${day}, ${date} de ${month} de ${year}`
        }

        document.getElementById("btnEnviaForm").addEventListener("click", function(event) {
            let formulario = document.getElementById('form')
            const dados = new FormData(formulario)
            passou = true;

            $("form#form :input").on('input', function() {
                $(this).attr('style', 'border: 1px solid #00B3BB !important');
                $(this).removeClass('is-invalid');
                $(this).removeClass('is-valid');
            });

            $("form#form :input").each(function() {
                var input = $(this);

                if (input.hasClass('required')) {
                    if (input.val() == '') {
                        input.addClass('is-invalid');
                        input.attr('style', 'border-color: red !important');
                        passou = false;
                    } else {
                        input.addClass('is-valid');
                        input.attr('style', 'border-color: green !important');
                    }
                }
            });
            if (passou) {
                axios.post("{{ route('controle.agendamentos.store.recorrente') }}", {
                        title: dados.get('title'),
                        description: dados.get('description'),
                        agendamento_id: "{{ isset($agendamento) ? $agendamento->id : null }}",
                        alterar_antigos: dados.get('alterar_antigos'),
                        bloco_id: dados.get('bloco_id'),
                        sala_id: dados.get('sala_id'),
                        professor_id: dados.get('professor_id'),
                        quantidade_pessoas: dados.get('quantidade_pessoas'),
                        publico_alvo: dados.get('publico_alvo'),
                        horario_inicial_1: dados.get('horario_inicial_1'),
                        horario_inicial_2: dados.get('horario_inicial_2'),
                        horario_inicial_3: dados.get('horario_inicial_3'),
                        horario_inicial_4: dados.get('horario_inicial_4'),
                        horario_inicial_5: dados.get('horario_inicial_5'),
                        horario_inicial_6: dados.get('horario_inicial_6'),
                        horario_inicial_7: dados.get('horario_inicial_7'),
                        horario_final_1: dados.get('horario_final_1'),
                        horario_final_2: dados.get('horario_final_2'),
                        horario_final_3: dados.get('horario_final_3'),
                        horario_final_4: dados.get('horario_final_4'),
                        horario_final_5: dados.get('horario_final_5'),
                        horario_final_6: dados.get('horario_final_6'),
                        horario_final_7: dados.get('horario_final_7'),
                        data_inicio: dados.get('data_inicio'),
                        data_fim: dados.get('data_fim'),
                        dia_semana: dados.getAll('dia_semana[]'),
                        tipo_id: dados.get('tipo_id'),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(response => {
                        //formatar
                        if(response.status == 201 && response.data.feriados){
                            let feriados = '<b>Atenção!</b>';
                            feriados += '<br>';
                            feriados += '<b>Período selecionado contempla feriado</b>';
                            feriados += '<br>';                            
                            response.data.feriados.forEach(element => {
                                feriados += formataData(element.data);
                                feriados += '<br>';
                            });
                            Swal.fire({
                                    title: response.data.msg,
                                    html: feriados,
                                    icon: 'warning',
                                    confirmButtonText: 'OK'
                                })
                                .then((result) => {
                                    if (result.isConfirmed || result.isDismissed) {
                                        window.location.href =
                                            "{{ route('controle.agendamentos.index') }}"
                                    }
                                })
                        }else if (response.status == 201) {
                            Swal.fire({
                                    title: response.data.msg,
                                    icon: response.data.error ? 'error' : 'success',
                                    confirmButtonText: 'OK'
                                })
                                .then((result) => {
                                    if (result.isConfirmed || result.isDismissed) {
                                        window.location.href =
                                            "{{ route('controle.agendamentos.index') }}"
                                    }
                                })
                        } else if (response.status == 200) {

                            const data_formatada = response.data.evento ? formataData(response.data
                                .evento
                                .start) : '';

                            console.log(response);

                            const hora_inicial = moment(response.data.evento.start).format('HH:mm')
                            const hora_final = moment(response.data.evento.end).format('HH:mm')

                            Swal.fire({
                                title: response.data.msg,
                                icon: response.data.error ? 'error' : 'success',
                                html: response.data.evento ? '<b>' + response.data.evento
                                    .title +
                                    '</b><br>' + data_formatada + '<br>' + hora_inicial + ' até as ' +
                                    hora_final : '',
                                confirmButtonText: 'OK'
                            })
                        } else {
                            Swal.fire({
                                title: response.data.msg,
                                icon: 'info',
                                confirmButtonText: 'OK'
                            })
                        }


                    })
                    .catch(err => {
                        console.error(err);
                    })
            } else {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'Preencha corretamente todos os campos obrigatórios!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                })
            }
        })
    </script>
    <script>
        $(document).ready(function() {
            $(".select2").select2({
                width: '100%'
            });

            $('#timepicker').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#timepicker').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#timepicker').timepicker('setTime', '7:30');
            });

            $('#timepicker2').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#timepicker2').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#timepicker2').timepicker('setTime', '7:30');
            });

            $('#horario_inicial_1').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_inicial_1').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_inicial_1').timepicker('setTime', '7:30');
            });

            $('#horario_final_1').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_final_1').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_final_1').timepicker('setTime', '7:30');
            });

            $('#horario_inicial_2').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_inicial_2').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_inicial_2').timepicker('setTime', '7:30');
            });

            $('#horario_final_2').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_final_2').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_final_2').timepicker('setTime', '7:30');
            });

            $('#horario_inicial_3').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_inicial_3').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_inicial_3').timepicker('setTime', '7:30');
            });

            $('#horario_final_3').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_final_3').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_final_3').timepicker('setTime', '7:30');
            });

            $('#horario_inicial_4').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_inicial_4').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_inicial_4').timepicker('setTime', '7:30');
            });

            $('#horario_final_4').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_final_4').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_final_4').timepicker('setTime', '7:30');
            });

            $('#horario_inicial_5').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_inicial_5').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_inicial_5').timepicker('setTime', '7:30');
            });

            $('#horario_final_5').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_final_5').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_final_5').timepicker('setTime', '7:30');
            });

            $('#horario_inicial_6').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_inicial_6').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_inicial_6').timepicker('setTime', '7:30');
            });

            $('#horario_final_6').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_final_6').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_final_6').timepicker('setTime', '7:30');
            });

            $('#horario_inicial_7').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_inicial_7').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_inicial_7').timepicker('setTime', '7:30');
            });

            $('#horario_final_7').timepicker({
                modalBackdrop: true,
                showMeridian: false,
            }).on('changeTime.timepicker', function(e) {
                var h = e.time.hours;
                var m = e.time.minutes;
                var mer = e.time.meridian;
                //convert hours into minutes
                m += h * 60;
                //10:15 = 10h*60m + 15m = 615 min
                if (m < 450)
                    $('#horario_final_7').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#horario_final_7').timepicker('setTime', '7:30');
            });
        });
    </script>

    <script>
        const toggleData = (select, id) => {

            horario = document.getElementById(`horario[${id}]`)
            horario_id = document.getElementById(`horario_id[${id}]`)

            if (select.checked) {
                horario.classList.remove("d-none")
                horario.classList.add("d-flex")

            } else {
                horario.classList.remove("d-flex")
                horario.classList.add("d-none")

            }
        }
    </script>
    <script>
        document.getElementById("btnUpdate").addEventListener("click", function(event) {
            let formulario = document.getElementById('formUpdate')
            const dados = new FormData(formulario)

            passou = true;

            $("form#formUpdate :input").on('input', function() {
                $(this).attr('style', 'border: 1px solid #00B3BB !important');
                $(this).removeClass('is-invalid');
                $(this).removeClass('is-valid');
            });

            $("form#formUpdate :input").each(function() {
                var input = $(this);

                if (input.hasClass('required')) {
                    if (input.val() == '') {
                        input.addClass('is-invalid');
                        input.attr('style', 'border-color: red !important');
                        passou = false;
                    } else {
                        input.addClass('is-valid');
                        input.attr('style', 'border-color: green !important');
                    }
                }

                // if (input.val().length > 0) {

                //     if (input.hasClass('date')) {
                //         if (input.val().length == 10) {
                //             input.addClass('is-valid');
                //             input.attr('style', 'border-color: green !important');
                //         } else {
                //             passou = false;
                //             input.addClass('is-invalid');
                //             input.attr('style', 'border-color: red !important');
                //         }
                //     }

                //     if (input.hasClass('numeric')) {
                //         if (!isNaN(input.val())) {
                //             input.addClass('is-valid');
                //             input.attr('style', 'border-color: green !important');
                //         } else {
                //             passou = false;
                //             input.addClass('is-invalid');
                //             input.attr('style', 'border-color: red !important');
                //         }
                //     }
                // }
            });
            if (passou) {
                axios.put("{{ route('controle.agendamentos.update') }}", {
                        id: dados.get('id'),
                        title: dados.get('title'),
                        description: dados.get('description'),
                        bloco_id: dados.get('bloco_id'),
                        sala_id: dados.get('sala_id'),
                        professor_id: dados.get('professor_id'),
                        horario_inicial: dados.get('horario_inicial'),
                        horario_final: dados.get('horario_final'),
                        tipo_id: dados.get('tipo_id'),
                        data_inicio: dados.get('data_inicio'),
                        data_fim: dados.get('data_inicio'),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(function(response) {

                        if (response.status == 201) {
                            Swal.fire({
                                    title: response.data.msg,
                                    icon: response.data.error ? 'error' : 'success',
                                    confirmButtonText: 'OK'
                                })
                                .then((result) => {
                                    if (result.isConfirmed || result.isDismissed) {
                                        window.location.reload()
                                    }
                                })
                        } else if (response.status == 200) {

                            const data_formatada = response.data.evento ? formataData(response.data
                                .evento
                                .start) : '';

                            const hora_inicial = moment(response.data.evento.start).format('HH:mm')
                            const hora_final = moment(response.data.evento.end).format('HH:mm')

                            Swal.fire({
                                title: response.data.msg,
                                icon: response.data.error ? 'error' : 'success',
                                html: response.data.evento ? '<b>' + response.data.evento
                                    .title +
                                    '</b><br>' + data_formatada + '<br>' + hora_inicial + ' até as ' +
                                    hora_final : '',
                                confirmButtonText: 'OK'
                            })
                        } else {
                            Swal.fire({
                                title: 'Atenção!',
                                text: response.data.msg,
                                icon: 'warning',
                                confirmButtonText: 'OK'
                            })
                        }
                    })
                    .catch(function(err) {
                        let erros = '';
                        for (var chave in err.response.data.errors) {
                            for (var erro of err.response.data.errors[chave]) {
                                erros += erro + '</br>';
                            }
                        }

                        Swal.fire({
                            title: 'Atenção',
                            html: erros,
                            icon: 'warning',
                            confirmButtonText: 'OK'
                        })
                    });
            }
        })
    </script>
    <script>
        document.getElementById("bloco").addEventListener("change", function(event) {
            bloco_id = event.srcElement.value

            axios.post("{{ route('controle.bloco.show') }}", {
                    bloco_id: bloco_id
                })
                .then(res => {

                    $("#salas").html('');
                    for (sala of res.data.bloco.salas) {
                        $("#salas").append(
                            `<option value ="${sala.id}"> ${sala.titulo}</option>`)
                    }



                })
                .catch(err => {
                    console.error(err);
                })
        })
    </script>
    <script>
        const eventClick = (evento_id) => {

            if (requisicao_em_andamento == 0) {
                requisicao_em_andamento = 1
                axios.post("{{ route('controle.agendamentos.detail') }}", {
                        id: evento_id
                    })
                    .then(res => {

                        axios.post("{{ route('controle.bloco.show') }}", {
                                bloco_id: res.data.bloco_id
                            })
                            .then(response => {

                                bloco_id = document.getElementById("bloco_id");
                                bloco_id.value = response.data.bloco.id

                                $("#sala_id").html('');
                                for (sala of response.data.bloco.salas) {
                                    $("#sala_id").append(
                                        `<option value ="${sala.id}"> ${sala.titulo}</option>`)
                                }

                                $("#sala_remarcacao").html('');
                                for (sala of response.data.bloco.salas) {
                                    $("#sala_remarcacao").append(
                                        `<option value ="${sala.id}"> ${sala.titulo}</option>`)
                                }

                                id = document.querySelector('.id')
                                id.value = res.data.id

                                title = document.querySelector('.title')
                                title.value = res.data.title

                                description = document.querySelector('.description')
                                description.value = res.data.description

                                sala_id = document.querySelector('.sala')
                                sala_id.value = res.data.sala_id

                                professor_id = document.querySelector('.professor')
                                professor_id.value = res.data.professor_id

                                tipo_id = document.querySelector('.tipo')
                                tipo_id.value = res.data.tipo_id

                                data_inicio = document.querySelector('.start')
                                data_hora = res.data.start.split(" ")
                                data_start = data_hora[0]
                                hora_start = data_hora[1]
                                data_inicio.value = data_start

                                horario_inicial = document.querySelector('.horario_inicial')
                                horario_inicial.value = hora_start.substr(0, hora_start.length - 3)

                                horario_final = document.querySelector('.horario_final')
                                data_hora_end = res.data.end.split(" ")
                                hora_end = data_hora_end[1]
                                horario_final.value = hora_end.substr(0, hora_end.length - 3)
                            })

                        $('#form-calendar-update').modal('show');
                        requisicao_em_andamento = 0
                    })
                    .catch(function(error) {
                        // console.log(error);
                    });
            }
        }
    </script>
@endpush
