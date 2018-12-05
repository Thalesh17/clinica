$(function() {
    var evt = [];
        $.ajax({
        url: urlBase + 'medico/getCalendario',
        type: "GET",
        dataType: "JSON",
        async: false
    }).done(function (r) {
        evt = r;
    });

    $('#calendario').fullCalendar({
        height: 650,
        defaultView: 'agendaWeek',
        businessHours: true,
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay,listDay'
        },
       events: evt,
        eventClick: function (objEvent){
            swal({
                title: 'Consulta com o Paciente <br>' + objEvent.title,
                html:'<p style="text-align: center;">Data da Consulta: ' + objEvent.start.format('DD/MM/YYYY') + '</p>'  + '<p style="text-align: center;">Horario: ' + objEvent.start.format('HH:mm') +'</p>',
                type: "info",
                showConfirmButton: true
                })
            }
    })

});