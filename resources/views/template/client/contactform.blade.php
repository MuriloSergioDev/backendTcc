@component('mail::message')
# {{$subject}}

## Titulo: {{$evento->title}}
## Tipo: {{$evento->tipo->titulo}}
## Bloco: {{$evento->bloco->titulo}} - Sala: {{$evento->sala->titulo}} 
## Dia: {{date('d/m/Y', strtotime($evento->getDataStart()))}} - Horário: {{$evento->getTimeStart()}} ás {{$evento->getTimeEnd()}}

@component('mail::button', ['url' => 'https://iced.sitebeta.com.br/'])
Acessar Sistema de agendamentos Iced
@endcomponent

Atenciosamente, Equipe Iced<br>

@endcomponent
