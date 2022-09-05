startCalendar();
var dataSelecionada;
var horaSelecionada;
var $btnRepetir;
var calendar;
$('.setcolor').click(function(){
  var color = $(this).data('color');
  $('#button-addon2').css({"background-color": color})
  $('input[name="color"]').val(color);
})
function startCalendar() {
      document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendario');
        calendar = new FullCalendar.Calendar(calendarEl, {
          // slotEventOverlap: false,
          // editable: true,
          themeSystem: 'bootstrap',
          // plugins: [ 'interaction', 'dayGrid', 'timeGrid' , 'bootstrap'],
          // plugins: [ 'dayGridPlugin' ],
          locale: 'pt-br',
          header: {
            left: 'prev,next today',
            center: 'title',
            // right: 'dayGridMonth,timeGridWeek,timeGridDay'
            // right: 'listDay,dayGridMonth'
          },
          views: {
            listDay: { buttonText: 'list day' },
            listWeek: { buttonText: 'list week' }
          },
          headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,dayGridWeek,dayGridDay'
          },
          initialView: 'dayGridWeek',
          defaultView: 'dayGridWeek',
          navLinks: true, // can click day/week names to navigate views
          eventLimit: true, // allow "more" link when too many events
          eventDrop: function(info) {
            // alert(info.event.title + " was dropped on " + info.event.start.toISOString());
            if (!confirm("Are you sure about this change?")) {
              info.revert();
            } else {
              console.log(info.event)
            }
          },
          events: function (time, callback, error) {
            // var moment = $('.calendar').fullCalendar('getDate');
            var url = '/controle/load-agendamentos';
            $.ajax({
                url: url,
                data: {
                    start: time.startStr,
                    end: time.endStr,
                },
                type: "GET",
                dataType: "json",
                success: function (json) {
                    $('.overlay').hide();
                    callback(json);
                }
            });
          },
        });
        /*
        if (getUrlParameter('data')) {
          calendar.changeView('timeGridDay', getUrlParameter('data'));
        }
        */
        calendar.on('dateClick', function(info) {
          $('#modalEvento').find('input[name="start"]').val(info.dateStr);
          // $('#modalEvento').find('input[name="end"]').val(info.dateStr);
          // if(view.name != "month"){
          //     horaSelecionada = date.format('HH:mm');
          //     $('#modalEvento').find('input[name="start"]').val(info.dateStr);
          //     $('#modalEvento').find('input[name="data_fim"]').val(info.dateStr);
          // }
          $('#modalEvento').modal('show');
        })
        calendar.changeView('timeGridDay', function(a, b, c) {
          console.log(a, b, c)
        });

        calendar.on('eventClick', function(info) {
          // console.log(info.event.id)
          var url = '/controle/agendamento/show/' + info.event.id;
          $.ajax({
              type: "GET",
              url: url,
              data: {
                  id: info.event.id
              },
              dataType: "json",
              success: function (response) {
                  montarReserva(response);
              }
          });
          $(this).css('border-color', 'red');

        });

        calendar.render();
      });
}

function getUrlParameter(name) {
  name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
  var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
  var results = regex.exec(location.search);
  return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
};

$('#modalEvento').on('hidden.bs.modal', function () {
  var modal = $("#modalEvento");
    modal.find('input[name="start"]').val('');
    modal.find('input[name="title"]').val('');
    modal.find('textarea[name="descricao"]').val('');
    modal.find('#btn-excluir').attr('data-evento_id', '');
    /*
    var modal = $('#modalEvento');
    modal.find('input[name="start"]').val('');
    modal.find('input[name="data_fim"]').val('');
    modal.find('input[name="hora_inicio"]').val('');
    modal.find('input[name="hora_termino"]').val('');
    modal.find('select[name="medico_id"]').val('').change();
    modal.find('textarea[name="observacao"]').val('');
    modal.find('button[type="submit"]').button('reset');
    modal.find('input[name="valor_calculo"]').val(null);
    modal.find('select[name="repetir"]').val(1).change();
    modal.find("#responsaAgendamentoAjax").hide().html('');
    $('.salvar').prop('disabled', true);
    */
})

$("#eventoDetalhe").delegate("#btn-excluir", "click", function(e){
  // $('.excluirReserva2').click(function(){
      var evento_id = $("#eventoDetalhe").find('[name="id_evento_h"]').val();
      // var evento_id = $('#eventoDetalhe').find('#btn-excluir').data('href');
      console.log(evento_id, excluirEvento);
      e.preventDefault();
      $.ajax({
          type: "GET",
          url: excluirEvento + '/' + evento_id,
          dataType: "json",
          success: function (response) {
            console.log(response.error)
              if(response.error === false){
                  $("#modalReserva").modal('hide');
                  let event = calendar.getEventById( evento_id )
                  event.remove()
                  $.gritter.add({
                    title: 'Sucesso!',
                    text: "<span style='color:#FFF;font-size:13px'>Agendamento removido</span>",
                    image: '/coloradmin/images/success.png',
                    sticky: false,
                    time: 1000,
                  });
                  $("#eventoDetalhe").modal('hide');
              } else {
                $.gritter.add({
                  title: val,
                  text: "<span style='color:#FFF;font-size:13px'>Houve um erro ao remover evento</span>",
                  image: '/coloradmin/images/error.png',
                  sticky: false,
                  time: 3000,
                });
              }
          }
      });
});

function dataAtualFormatada(date){
  var data = new Date(date);
      dia  = data.getDate().toString(),
      diaF = (dia.length == 1) ? '0'+dia : dia,
      mes  = (data.getMonth()+1).toString(), //+1 pois no getMonth Janeiro começa com zero.
      mesF = (mes.length == 1) ? '0'+mes : mes,
      anoF = data.getFullYear();
  return diaF+"/"+mesF+"/"+anoF;
  // return data.getHours()
}


function montarReserva(response, tipo = 'agendamento')
{
  let time =  response.start.split(' ');
  let data = time[0].split('-');
  var modal = $("#eventoDetalhe");
  modal.find('.start').text(data[2] + '/' + data[1] + '/' + data[0] + ' ' + time[1]);
  modal.find('.title').text(response.title);
  modal.find('.descricao').text(response.descricao);
  // modal.find('#excluirEvent').attr('data-link', '/controle/agendamento-sala/excluir-reserva/'+response.id);
  modal.modal('show');
  let linkUpdate = modal.find('#btn-editar').data('href') + '/' + response.id;
  modal.find('#btn-editar').attr('href', linkUpdate);
  // modal.find('#btn-excluir').attr('href', modal.find('#btn-excluir').data('href').replace('/0', '') + '/' + response.id);
  modal.find('#btn-excluir').attr('data-evento_id', response.id );
  modal.find('[name="id_evento_h"]').val(response.id);
}
$('#modalReserva').on('hidden.bs.modal', function () {
    var modal = $("#modalReserva");
    modal.find('input[name="start"]').val('');
    modal.find('input[name="title"]').val('');
    modal.find('textarea[name="descricao"]').val('');
    modal.find('#btn-excluir').attr('data-evento_id', '');
    modal.find('[name="id_evento_h"]').val('')
});
$("#modalEvento").on('#btn-excluir', 'click', function() {

});
$("#modalEvento").find('form').on('submit', function(e){
    var form    = $("#modalEvento").find('form');
    var dados   = form.serialize();
    var url     = form.attr('action');
    // var disponiel = form.find('input[name="valor_calculo"]').val();
    var $btn = $('.salvar');
    // dados[9] = {name: 'acao', value: 'ajax'};
    // if(disponiel == ""){

    // } else {
    //     $btn.button('loading');
    // }
    // $("#responsaAgendamentoAjax").hide().html('');
    $.ajax({
        type: "POST",
        url: url,
        data: dados,
        dataType: "json",
        success: function (response) {
            if (response.error == true) {
                // if(response.msg.length > 0){
                //     $.each(response.msg, function(index, val){
                //         $("#responsaAgendamentoAjax").removeClass('alert-success').addClass("alert-danger").show().append("<p>"+val+"</p>");
                //     })
                // }
                // $('input[name="valor_calculo"]').val(null);
                $btn.prop('disabled', true);
            } else {
                $btn.prop('disabled', false);
                if (response.id) {
                    calendar.addEvent({
                      id: response.id,
                      title: response.title,
                      start: response.start,
                      end: response.end,
                      color: response.color,
                    });
                    $.gritter.add({
                      title: 'Sucesso!',
                      text: "<span style='color:#FFF;font-size:13px'>As reservas foram realizadas!</span>",
                      image: '/coloradmin/images/success.png',
                      sticky: false,
                      time: 1000,
                    });
                    $("#modalEvento").modal('hide');
                } else {
                  if (response.agendamentos.length > 0) {
                    $.each(response.msg, function(index, val){
                        $("#responsaAgendamentoAjax").removeClass('alert-danger').addClass("alert-success").show();
                        $("#responsaAgendamentoAjax").append("<p>" + val + "</p>");
                    })
                  }
                }
                $btn.button('reset');
            }
        }
    })
    .fail(function(er){
        if(er.responseJSON != undefined) {
            $.each(er.responseJSON.errors, function(index, erro){
                $.each(erro, function(index, val){
                    $.gritter.add({
                      title: val,
                      text: "<span style='color:#FFF;font-size:13px'>Houve um erro ao atualizar!</span>",
                      image: '/coloradmin/images/error.png',
                      sticky: false,
                      time: 3000,
                    });
                });
            })
        }
    })
    .done(function(er){
      $btn.button('reset');
      $btn.prop('disabled', false);
        if ($btnRepetir != undefined) {
            $btnRepetir.button('reset');
        }
    });

    return false;

});
