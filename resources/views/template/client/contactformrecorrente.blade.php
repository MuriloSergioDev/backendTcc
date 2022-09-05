@component('mail::message')
# {{ $subject }}

## Titulo: {{ $agendamento->titulo }}
## Tipo: {{$tipo->titulo}}
## Descrição: {{ $agendamento->descricao }}
## Período: {{ date('d/m/Y', strtotime($agendamento->data_inicio)) }} - {{ date('d/m/Y', strtotime($agendamento->data_fim)) }}
## Bloco: {{ $bloco->titulo }} - Sala: {{ $sala->titulo }}

# Dias da semana:
@foreach ($dias_da_semana as $key => $dia_da_semana)
@if (in_array($key, $input['dia_semana']))
@switch($key)
    @case('1')
## Segunda-feira
        @break
    
    @case('2')
## Terça-feira
        @break

    @case('3')
## Quarta-feira
        @break

    @case('4')
## Quinta-feira
        @break

    @case('5')
## Sexta-feira
        @break

    @case('6')
## Sábado
        @break

    @case('1')
## Domingo
        @break

    @default                
@endswitch        
## Horário: {{ $input['horario_inicial_' . $key] }} ás {{ $input['horario_final_' . $key] }}
@endif
@endforeach


@component('mail::button', ['url' => 'https://iced.sitebeta.com.br/'])
Acessar Sistema de agendamentos Iced
@endcomponent

Atenciosamente, Equipe Iced<br>

@endcomponent
