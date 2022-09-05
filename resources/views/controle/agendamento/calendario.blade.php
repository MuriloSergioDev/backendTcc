@section('title', 'Agendamentos')
@extends('layouts.default')

@push('css')
    <link href="/assets/plugins/fullcalendar/dist/fullcalendar.print.css" rel="stylesheet" media='print' />
    <link href="/assets/plugins/fullcalendar/dist/fullcalendar.min.css" rel="stylesheet" />    
    <style>
        table td {
            overflow: inherit !important;
        }

        .modal.show::-webkit-scrollbar {
            display: none;
        }

        .fc .fc-event:focus,
        .fc .fc-event:hover,
        .fc a.fc-event:focus,
        .fc a.fc-event:hover {
            background: rgba(54, 88, 88, 0.5) !important;
        }

        .fc .fc-list-event:hover td {
            background: rgba(54, 88, 88, 0.5) !important;
        }


        @media(max-width:1920px) {
            .fc-event-time {
                width: 95px;
            }
        }

        @media(max-width:1440px) {
            .fc-event-time {
                width: 133px;
            }
        }

        @media(max-width:978px) {
            .fc-event-time {
                font-size: 9px !important;
            }

            .fc-event-title {
                display: none !important;
            }
        }

        .fc-list-event-title {
            width: 100%;
        }

        ul.lista-cliente {
            list-style-type: square;
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

        .modal {
            overflow-y: auto;
        }

    </style>
    <link href="/assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet" />
@endpush

@section('content')
    <!-- begin breadcrumb -->
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active"><a href="javascript:;">Agendamento</a></li>
    </ol>

    <h1 class="page-header">Agendamentos</h1>

    @if (isset($blocos))
        <!-- begin form-filter -->
        <div class="col-lg-7">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <h4 class="panel-title">Filtrar</h4>
                </div>
                <div class="panel-body">

                    {!! Form::model(isset($input) ? $input : null, ['route' => 'controle.agendamentos.calendario', 'method' => 'get', 'id' => 'form-busca']) !!}
                    <div class="d-flex flex-column mx-auto">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="form-group col-md-6">
                                <label for="bloco_id">Bloco</label>
                                {!! Form::select('bloco_id', isset($blocos) > 0 ? [null => 'TODOS OS BLOCOS'] + $blocos : [null => 'Nenhuma bloco cadastrada'], isset($bloco) ? [$bloco->titulo => $bloco->id] : [null => 'Nenhuma bloco selecionada'], ['class' => 'form-control select2']) !!}
                            </div>

                            <div class="form-group col-md-6">
                                <label for="sala_id">Sala</label>
                                {!! Form::select('sala_id', isset($salas) > 0 ? [null => 'TODAS AS SALAS'] + $salas : [null => 'Nenhuma sala cadastrada'], isset($sala_selecionada) ? [$sala_selecionada->titulo => $sala_selecionada->id] : [null => 'Nenhuma sala selecionada'], ['class' => 'form-control select2']) !!}
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="professor_id">Professor</label>
                            {!! Form::select('professor_id', isset($professores) > 0 ? [null => 'TODOS OS PROFESSORES'] + $professores : [null => 'Nenhuma professor cadastrado'], isset($professor) ? [$professor->titulo => $professor->id] : [null => 'Nenhum professor selecionado'], ['class' => 'form-control select2']) !!}
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
                        <h4 class="panel-title">Lista de Agendamentos</h4>
                        <div class="panel-heading-btn">
                            @if (isset($bloco))
                                <a href="{{ route('controle.agendamentos.create') }}"
                                    class="btn btn-xs btn-circle2 btn-primary"><i class="fa fa-plus"></i> Marcar
                                    agendamento
                                    recorrente</a>
                            @endif
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default"
                                data-click="panel-expand"><i class="fa fa-expand"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning"
                                data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                            <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger"
                                data-click="panel-remove"><i class="fa fa-times"></i></a>
                        </div>
                    </div>
                    <div class="panel-body">
                        <!-- begin calendar -->
                        <div id="calendario"></div>

                        <!-- end calendar -->
                        <div class="modal" tabindex="-1" role="dialog" id="form-calendar">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Marcar agendamento simples</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::model(null, ['route' => 'controle.agendamentos.store', 'id' => 'form']) !!}

                                        <div class="form-group">
                                            <label for="bloco_id">Bloco*</label>
                                            {!! Form::select('bloco_id', count($blocos) ? [null => 'Selecione um bloco'] + $blocos : [null => 'Nenhuma bloco cadastrado'], isset($bloco) ? [$bloco->titulo => $bloco->id] : null, ['class' => 'form-control select2 required', 'required', 'id' => 'bloco1']) !!}
                                            <div class="invalid-feedback">
                                                <p>Este campo é obrigatório</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="tipo_id">Tipo*</label>
                                            {!! Form::select('tipo_id', count($tipos) ? [null => 'Selecione um tipo'] + $tipos : [null => 'Nenhuma tipo cadastrado'], null, ['class' => 'form-control select2 required', 'required', 'id' => 'tipo1']) !!}
                                            <div class="invalid-feedback">
                                                <p>Este campo é obrigatório</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="title">Título*</label>
                                            {!! Form::text('title', null, ['class' => 'form-control required', 'required', 'id' => 'title']) !!}
                                            <div class="invalid-feedback">
                                                <p>Este campo é obrigatório</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="description">Descrição</label>
                                            {!! Form::textarea('description', null, ['class' => 'form-control', 'id' => 'description']) !!}
                                        </div>

                                        <div class="form-group">
                                            <label for="professor_id">Professor</label>
                                            {!! Form::select('professor_id', count($professores) ? $professores : [null => 'Nenhum professor cadastrado'], null, ['class' => 'form-control select2', 'required', 'id' => 'professor']) !!}
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-6">
                                                <label for="sala_id">Sala*</label>
                                                {!! Form::select('sala_id', count($salas) ? $salas : [null => 'Nenhuma sala cadastrada'], null, ['class' => 'form-control select2 required', 'required', 'id' => 'sala_novo']) !!}
                                                <div class="invalid-feedback">
                                                    <p>Este campo é obrigatório</p>
                                                </div>
                                            </div>


                                            <div class="col-md-6">
                                                <label for="data_inicio">Data*</label>
                                                {!! Form::date('data_inicio', null, ['class' => 'form-control data_inicio required', 'id' => 'data_inicio']) !!}
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
                                                        <input name="horario_inicial" id="timepicker" type="text"
                                                            class="form-control" />
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label">Horário Final</label>
                                                <div>
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input name="horario_final" id="timepicker2" type="text"
                                                            class="form-control" />
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Quantidade de pessoas*</label>
                                                <input type="number" name="quantidade_pessoas" class="form-control required" required min="1" value="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Público Alvo*</label>
                                                <input type="text" name="publico_alvo" class="form-control required" required/>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" id="btnCreate">Confirmar</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal" tabindex="-1" role="dialog" id="form-calendar-update">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Alterar agendamento</h5>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        {!! Form::model(null, ['route' => 'controle.agendamentos.update', 'id' => 'formUpdate']) !!}

                                        {!! Form::hidden('id', null, ['class' => 'form-control id']) !!}

                                        <div class="form-group">
                                            <label for="bloco_id">Bloco*</label>
                                            {!! Form::select('bloco_id', count($blocos) ? [null => 'Selecione um bloco'] + $blocos : [null => 'Nenhuma bloco cadastrado'], null, ['class' => 'form-control select2 bloco required', 'required', 'id' => 'bloco2']) !!}
                                            <div class="invalid-feedback">
                                                <p>Este campo é obrigatório</p>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="tipo_id">Tipo*</label>
                                            {!! Form::select('tipo_id', count($tipos) ? [null => 'Selecione um tipo'] + $tipos : [null => 'Nenhuma tipo cadastrado'], null, ['class' => 'form-control select2 tipo required', 'required', 'id' => 'tipo2']) !!}
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
                                            {!! Form::select('professor_id', count($professores) ? $professores : [null => 'Nenhum professor cadastrado'], null, ['class' => 'form-control select2 professor', 'required', 'professor']) !!}
                                        </div>

                                        <div class="form-group row">

                                            <div class="col-md-6">
                                                <label for="sala_id">Sala*</label>
                                                {!! Form::select('sala_id', [null => 'Selecione um bloco'], null, ['class' => 'form-control select2 sala required', 'required', 'id' => 'sala2']) !!}
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

                                            {!! Form::hidden('data_fim', null, ['class' => 'form-control end']) !!}
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label class="col-form-label">Horário Inicial</label>
                                                <div>
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input name="horario_inicial" id="timepicker3" type="text"
                                                            class="form-control horario_inicial" />
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <label class="col-form-label">Horário Final</label>
                                                <div>
                                                    <div class="input-group bootstrap-timepicker">
                                                        <input name="horario_final" id="timepicker4" type="text"
                                                            class="form-control horario_final" />
                                                        <span class="input-group-addon"><i
                                                                class="fa fa-clock"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <div class="col-md-6">
                                                <label>Quantidade de pessoas*</label>
                                                <input type="number" name="quantidade_pessoas" class="form-control quantidade_pessoas required" required min="1">
                                            </div>
                                            <div class="col-md-6">
                                                <label>Público Alvo*</label>
                                                <input type="text" name="publico_alvo" class="form-control publico_alvo required" required/>
                                            </div>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-danger" id="btnDelete">Remover</button>
                                            <button type="button" class="btn btn-primary" id="btnUpdate">Salvar</button>
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Cancelar</button>
                                        </div>
                                        {!! Form::close() !!}
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @else
        <h3>Cadastre um bloco para ter acesso a essa seção</h3>
    @endif
    </div>
@endsection

@push('scripts')
    <link rel="stylesheet" href="/js/fullcalendar-5.1.0/lib/main.min.css">
    <script src="/js/fullcalendar-5.1.0/lib/main.js"></script>
    <script src="/js/fullcalendar-5.1.0/lib/locales/pt-br.js"></script>
    <script src="/assets/plugins/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js"></script>
    <script src="https://rawgit.com/moment/moment/2.2.1/min/moment.min.js"></script>    

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

        let requisicao_em_andamento = 0        

        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendario');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                themeSystem: 'bootstrap',
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,dayGridWeek,dayGridDay,listDay,listWeek'
                },
                views: {
                    listDay: {
                        buttonText: 'Lista dia'
                    },
                    listWeek: {
                        buttonText: 'Lista semana'
                    },
                    listMonth: {
                        buttonText: 'Lista mês'
                    }
                },
                locale: 'pt-br',
                droppable: true, // this allows things to be dropped onto the calendar
                eventDisplay: 'block',
                eventOverlap: true,
                drop: function() {
                    $(this).remove();
                },
                selectOverlap: function(event) {},
                editable: true,
                eventDrop: function(info) {
                    let date = new Date(info.event.start);

                    var day = date.getDate(); //Date of the month: 2 in our example
                    var month = date.getMonth() +
                        1; //Month of the Year: 0-based index, so 1 in our example
                    var year = date.getFullYear() //Year: 2013
                    let new_date = year + '-' + month + '-' + day

                    var listEvent = calendar.getEvents();
                    listEvent.forEach(event => {
                        event.remove()
                    });

                    axios.put("{{ route('controle.agendamentos.update.data') }}", {
                            id: info.event.id,
                            data_inicio: new_date,
                            data_fim: new_date,
                            headers: {
                                'Content-Type': 'application/json'
                            },
                        })
                        .then(function(response) {
                            if (response.status == 202) {
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
                            } else {

                                const data_formatada = response.data.evento ? formataData(
                                    response.data
                                    .evento.start) : '';

                                const hora_inicial = moment(response.data.evento.start).format(
                                    'HH:mm')
                                const hora_final = moment(response.data.evento.end).format('HH:mm')

                                Swal.fire({
                                        title: response.data.msg,
                                        icon: response.data.error ? 'error' : 'success',
                                        html: response.data.evento ? '<b>' + response.data
                                            .evento
                                            .title + '</b><br>' + data_formatada + ' de ' +
                                            hora_inicial +
                                            ' até ' + hora_final : '',
                                        confirmButtonText: 'OK'
                                    })
                                    .then((result) => {
                                        if (result.isConfirmed || result.isDismissed) {
                                            window.location.reload()
                                            // info.revert();
                                        }
                                    })
                            }

                        })
                        .catch(function(error) {
                            // console.log(error);
                        });
                },
                dateClick: function(info) {                    

                    axios.post("{{ route('controle.feriados.show') }}", {
                            data_celula: moment(info.date).format('L')
                        })
                        .then(res => {
                            console.log(res.data.disponibilidade);
                            if (res.data.disponibilidade) {
                                $('#form-calendar').modal('show');
                                data_inicio = document.querySelector('.data_inicio')
                                data_inicio.value = info.dateStr
                            } else {
                                Swal.fire({
                                    title: 'Atenção',
                                    icon: 'warning',
                                    text: 'Não é possivel registrar evento nesta data',
                                    confirmButtonText: 'OK'
                                })
                            }
                        })
                        .catch(err => {
                            console.error(err);
                        })

                },                
                dayCellDidMount: function(info) {                                     

                    axios.post("{{ route('controle.feriados.show') }}", {
                            data_celula: moment(info.date).format('L')
                        })
                        .then(res => {                            
                            if (res.data.disponibilidade) {

                            } else {
                                // const data_formatada = info.event.start ? formataData(info.event
                                //     .start) : '';
                                if (res.data.feriado[0]) {                                    
                                    info.el.style.backgroundColor = "#8dccd9";
                                    info.el.style.display = "flex";
                                    info.el.style.flexDirection = "column";
                                    info.el.style.alignItems = "center";
                                    info.el.style.paddingTop = "20px";
                                    info.el.style.width = "100%";
                                    info.el.style.height = "100%";

                                    let html =
                                        `<div style="display:flex;flex-direction:column;align-itens:center">`
                                    html += `<span><b>Feriado</b></span>`
                                    html += `<span>${res.data.feriado[0].nome}</span>`
                                    html += `</div>`
                                    $(info.el).find('.fc-daygrid-day-frame').css({display:'none'})
                                    info.el.innerHTML = html;                                    
                                }
                            }
                        })
                        .catch(err => {
                            console.error(err);
                        })

                },                
                displayEventTime: false,
                eventDidMount: function(info) {                    
                    
                    axios.post("{{ route('controle.feriados.show') }}", {
                            data_celula: moment(info.event.startStr).format('L')
                        })
                        .then(res => {                            
                            if (res.data.disponibilidade) {                                
                                $(info.el).find('.fc-list-event-title a').append("<br/>" + (info
                                    .event._def
                                    .extendedProps.description ? info.event._def
                                    .extendedProps.description :
                                    ''))

                                const data_formatada = info.event.start ? formataData(info.event
                                    .start) : '';
                                const hora_inicial = moment(info.event.startStr).format('HH:mm')
                                const hora_final = moment(info.event.endStr).format('HH:mm')

                                let html = ''
                                html = html + `<div class="col-md-6">`
                                html = html +
                                    `<p>Professor: ${info.event._def.extendedProps.professor ? info.event._def.extendedProps.professor.nome : ''}</p>`

                                html = html + `</div>`

                                html = html + `<div class="col-md-6">`
                                html = html +
                                    `<p>Bloco: ${info.event._def.extendedProps.bloco ? info.event._def.extendedProps.bloco.titulo : ''}</p>`
                                html = html +
                                    `<p>Sala: ${info.event._def.extendedProps.sala ? info.event._def.extendedProps.sala.titulo : ''}</p>`

                                html = html + `</div>`


                                html = html + `<div class="mt-2">${data_formatada}</div>`                                
                                $(info.el).find('.fc-list-event-title a').append(html)                                                                                            
                                $(info.el).find('.fc-event-title').prepend(
                                    `${hora_inicial} - ${hora_final} `)
                            } else {
                                const data_formatada = info.event.start ? formataData(info.event
                                    .start) : '';
                                console.log('a');
                                $(info.el).find('.fc-event-time').attr("style", "display:none")
                            }
                        })
                        .catch(err => {
                            console.error(err);
                        })

                },
                events: "{{ route('controle.agendamentos.show', ['bloco_id' => isset($bloco) ? $bloco->id : 0, 'sala_id' => isset($sala_selecionada) ? $sala_selecionada->id : 0, 'professor_id' => isset($professor) ? $professor->id : 0]) }}",
                eventClick: function(info) {

                    bloco_id = event.srcElement.value



                    if (requisicao_em_andamento == 0) {
                        requisicao_em_andamento = 1
                        axios.post("{{ route('controle.agendamentos.detail') }}", {
                                id: info.event.id
                            })
                            .then(res => {

                                axios.post("{{ route('controle.bloco.show') }}", {
                                        bloco_id: res.data.bloco_id
                                    })
                                    .then(resp => {

                                        $("#sala2").html('');
                                        for (sala of resp.data.bloco.salas) {
                                            $("#sala2").append(
                                                `<option value ="${sala.id}"> ${sala.titulo}</option>`
                                            )
                                        }

                                        id = document.querySelector('.id')
                                        id.value = res.data.id

                                        title = document.querySelector('.title')
                                        title.value = res.data.title

                                        description = document.querySelector('.description')
                                        description.value = res.data.description

                                        // sala_id = document.querySelector('.sala')
                                        // sala_id.value = res.data.sala_id
                                        $('.sala').val(res.data.sala_id).trigger('change')

                                        // professor_id = document.querySelector('.professor')
                                        // professor_id.value = res.data.professor_id
                                        $('.professor').val(res.data.professor_id).trigger(
                                            'change')

                                        // bloco_id = document.querySelector('.bloco')
                                        // bloco_id.value = res.data.bloco_id
                                        $('.bloco').val(res.data.bloco_id).trigger('change')

                                        // tipo_id = document.querySelector('.tipo')
                                        // tipo_id.value = res.data.tipo_id
                                        $('.tipo').val(res.data.tipo_id).trigger('change')

                                        $('.quantidade_pessoas').val(res.data.quantidade_pessoas).trigger('change')

                                        $('.publico_alvo').val(res.data.publico_alvo).trigger('change')

                                        data_inicio = document.querySelector('.start')
                                        data_hora = res.data.start.split(" ")
                                        data_start = data_hora[0]
                                        hora_start = data_hora[1]
                                        data_inicio.value = data_start

                                        horario_inicial = document.querySelector(
                                            '.horario_inicial')
                                        horario_inicial.value = hora_start.substr(0, hora_start
                                            .length - 3)

                                        horario_final = document.querySelector('.horario_final')
                                        data_hora_end = res.data.end.split(" ")
                                        hora_end = data_hora_end[1]
                                        horario_final.value = hora_end.substr(0, hora_end
                                            .length - 3)

                                        $('#form-calendar-update').modal('show');
                                        requisicao_em_andamento = 0


                                    })
                                    .catch(err => {
                                        console.error(err);
                                    })

                            })
                            .catch(function(error) {
                                // console.log(error);
                            });
                    }
                }
            });
            calendar.render();
        });

        document.getElementById("btnCreate").addEventListener("click", function(event) {
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
                $('body').loadingModal({
                        text: 'Carregando...'
                });
                axios.post("{{ route('controle.agendamentos.store') }}", {
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
                        quantidade_pessoas: dados.get('quantidade_pessoas'),
                        publico_alvo: dados.get('publico_alvo'),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(function(response) {
                        $('body').loadingModal('destroy');
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
                        $('body').loadingModal('destroy');
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
            } else {
                Swal.fire({
                    title: 'Atenção!',
                    text: 'Preencha corretamente todos os campos obrigatórios!',
                    icon: 'warning',
                    confirmButtonText: 'OK'
                })
            }
        })

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
            });
            if (passou) {
                $('body').loadingModal({
                        text: 'Carregando...'
                });
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
                        quantidade_pessoas: dados.get('quantidade_pessoas'),
                        publico_alvo: dados.get('publico_alvo'),
                        headers: {
                            'Content-Type': 'application/json'
                        },
                    })
                    .then(function(response) {
                        $('body').loadingModal('destroy');
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
                        $('body').loadingModal('destroy');
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
        $(document).ready(function() {
            $(".select2").select2();
            $('#cp2').colorpicker();

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

            $('#timepicker3').timepicker({
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
                    $('#timepicker3').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#timepicker3').timepicker('setTime', '7:30');
            });

            $('#timepicker4').timepicker({
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
                    $('#timepicker4').timepicker('setTime', '22:00');

                if (m > 1320)
                    $('#timepicker4').timepicker('setTime', '7:30');
            });
        });
    </script>
    <script>
        document.getElementById("bloco1").addEventListener("change", function(event) {
            bloco_id = event.srcElement.value

            axios.post("{{ route('controle.bloco.show') }}", {
                    bloco_id: bloco_id
                })
                .then(res => {

                    $("#sala_novo").html('');
                    for (sala of res.data.bloco.salas) {
                        $("#sala_novo").append(
                            `<option value ="${sala.id}"> ${sala.titulo}</option>`)
                    }
                })
                .catch(err => {
                    console.error(err);
                })
        })

        document.getElementById("bloco2").addEventListener("change", function(event) {
            bloco_id = event.srcElement.value

            axios.post("{{ route('controle.bloco.show') }}", {
                    bloco_id: bloco_id
                })
                .then(res => {

                    $("#sala2").html('');
                    for (sala of res.data.bloco.salas) {
                        $("#sala2").append(
                            `<option value ="${sala.id}"> ${sala.titulo}</option>`)
                    }
                })
                .catch(err => {
                    console.error(err);
                })
        })
    </script>
    <style>
        .start.fc-event-end.fc-event-past {
            cursor: pointer !important;
        }

        .fc-daygrid-event-harness {
            cursor: pointer;
        }

        a.fc-daygrid-event.fc-daygrid-dot-event.fc-event.fc-event-start.fc-event-end.fc-event-past:hover {
            background: #2a72b5;
        }

    </style>
    {{-- <script src="/assets/js/demo/calendar.demo.js"></script> --}}
@endpush
