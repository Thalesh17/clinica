var categories = [];
for(var i = 1; i <= daysInThisMonth(); i++){
    categories.push(i);
}

var dates = [];
var time = [];
var datesForDisable = ["25.11.2018", "26.11.2018", "27.11.2018"]

$(document).ready(function () {

    $("#medico-select").attr('disabled', true);


    $('#date').inputmask("datetime",{
        mask: "1/2/y",
        placeholder: "__/__/____",
        leapday: "-02-29",
        separator: "/",
        alias: "dd-mm-yyyy"
    });

    var teste = $("#teste");
    teste.html('<option value="0">Selecione</option>');
    filterMes();
    filterAno();
    $('[data-toggle="tooltip"]').tooltip();

    //ESCOLHENDO MEDICO
    $("#medico-select").change(function () {
        var id = $(this).val();
        if($(this).val() == 0){
            console.log('sa');
            return '';
        }else{
            CustomPreload.show();
            $.ajax({
                type: 'GET',
                url: urlBase + 'consulta/getDates/' + id,
            }).done(function (data) {
                CustomPreload.hide();
                $('#date').datepicker({
                    timepicker: false,
                    language: 'pt-BR',
                    format: 'dd/mm/yyyy',
                    startDate: new Date(),
                    autoclose: true,
                    //USAR A FUNÇÃO QUANDO TIVER DATA D
                    beforeShowDay: function (currentDate) {
                        var dayNr = currentDate.getDay();
                        var dateNr = moment(currentDate.getDate()).format("DD-MM-YYYY");

                        if (datesForDisable.length > 0) {
                            for (var i = 0; i < data.length; i++) {
                                if (moment(currentDate).unix() == moment(data[i], 'DD.MM.YYYY').unix()) {
                                    return false;
                                }
                            }
                        }
                        return true;
                    },
                }).on('changeDate', function (d) {
                    CustomPreload.show();
                    var data = dateinConsulta(d.date);
                    $.ajax({
                        type: 'GET',
                        url: urlBase + 'consulta/getHorario/' + data + '/' + id,
                    }).done(function (result) {
                        teste.html('<option value="0">Selecione</option>');
                        for (var i = 0; i < result.length; i++) {
                            teste.append('<option value="' + result[i] + '">' + result[i] + '</option>');
                        }
                    });
                    CustomPreload.hide();
                })
            });
            CustomPreload.hide();
        }
    });

    $('body').on({
        mouseenter: function() {
            $(this).popover({
                content: 'Data Indisponivel',
                placement: 'top',
                container: '.datepicker',
                title: 'Consulta'
            }).popover('show');
        },
        mouseleave: function() {
            $(this).popover('hide')
        }
    }, '.datepicker .day.disabled');

    $("#content-modal-consulta").on("submit", "#form-consulta", function (event) {

        event.preventDefault();

        document.getElementById("salvar").disabled = true;

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "consulta/store",
            data: $("#form-consulta").serialize(),
            success: function (data) {
                if (data.success === true) {
                    $('#modal-form-consulta').modal('toggle');
                    setTimeout(function () {
                        swal({
                            title: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    });
                } else {
                    document.getElementById("salvar").disabled = false;
                    if (data.success === false) {
                        var erros = data.msg;
                        var keys = Object.keys(erros);
                        validateErrors(erros, keys, 'danger');

                    } else {

                        showAlertModal('warning', data.msg);

                    }
                }
            }
        });
    });

});

function dateinConsulta(date) {
    var dmy = "";
    dmy += ("00" + date.getDate()).slice(-2) + "-";
    dmy += ("00" + (date.getMonth() + 1)).slice(-2) + "-";
    dmy += date.getFullYear();

    return dmy;
}

function getMedico(event) {
    $("#medico-select").html('<option value="0">Carregando...</option>');
    // $("#medico-select").empty();
    var especialidade = event.target.value;
    CustomPreload.show();
    $.ajax({
        type : "GET",
        url : urlBase + "consulta/get-medico",
        data : "id="+especialidade,
        dataType : "json",
        success:function (result) {
            if(result.success === true){
                $("#medico-select").html('<option value="0">Selecione</option>');
                $("#medico-select").attr('disabled', false);
                $.each(result.result, function (index, medicoObj) {
                    $("#medico-select").append('<option value="'+medicoObj.id +'">'+ medicoObj.name + '</option>');
                })
            }else if(result.result == 0){
                $("#medico-select").html('<option value="0">Selecione</option>');
                $("#medico-select").attr('disabled', true);

            }else{
                swal({
                    title: 'Médico',
                    text: 'Não existe médicos cadastrados para essa Especialidade',
                    type: "error",
                    timer: 2000,
                    showConfirmButton: false
                });
                $("#medico-select").html('<option value="0">Selecione</option>');
            }
            CustomPreload.hide();
        }
    });
}

function adicionar() {
    $.get(urlBase + "consulta/create/", function(resposta){
        $("#content-modal-consulta").html(resposta);
        $('#modal-form-consulta').modal('show');
    }).fail(function(resposta) {

    });
}


function editar(id) {
    $.get(urlBase + "consulta/edit/" + id, function(resposta){
        $("#content-modal-consulta").html(resposta);
        $('#modal-form-consulta').modal('show');
    }).fail(function(resposta) {

    });
}

function deletar(id, nome, medico){

    swal({
        title: 'Excluir Consulta',
        html: 'Deseja realmente excluir a Consulta de <b>' + nome + '</b>' + ' com o(a) Médico(a) ' + medico + '?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00cebc",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        cancelButtonColor: "#222d32",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if(result.value) {
            $.ajax({
                type: "POST",
                url: urlBase + "consulta/delete",
                data: {_token: _token, id: id},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: 'Consulta',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        swal("Consulta", data.msg , "error");
                    }
                },
            })
        }
    });
}

var info = [];
var data1 = {};
function informativo() {
    $.ajax({
        type: "GET",
        url: urlBase + "consulta/informativo/user",
        success : function (data){
            if(data.length == 0){
                $("#chart").html('<div class="informative"><h3 class="msg-alert-filter text-center"><i class="fa fa-calendar-times-o"></i> Não foi encontrado nenhum dado de informativo.</h3></div>')
                return;
            }
            data.forEach(function(e) {
                info.push(e.user);
                data1[e.user] = e.count;
            });
            var chart = c3.generate({
                bindto: '#pie',
                size:{
                    height: 300,
                },
                data: {
                    json: [ data1 ],
                    keys: {
                        value: info,
                    },
                    type:'pie'
                },
                legend: {
                    position: 'right'
                },
                color: {
                    pattern: ['#D2691E','#FF0000', '#00FF00'],
                },
                tooltip: {
                    format: {
                        value: function(value, ratio, id) {
                            return value;
                        }
                    }
                },
            });
        } ,
        error : function (data) {

        }
    }).fail(function(resposta) {
        if(resposta.status == 401){
            swal("Funções", "Sem permissão para acessar essa funcionalidade." , "error");
        }
    });
}

function filterAno(){
    var currentYear = (new Date).getFullYear();

    $.ajax({
        type: "GET",
        dataType: 'json',
        url: urlBase + "informativo/getYearConsultas",
        data: $("#form-informativo").serialize(),
        success: function(response){
            if(response.length === 0){
                var ano = $("#disabledSelectAno :selected").text();
                if(ano === 'Selecione'){
                    $("#spm").html('<div class="informative"><h3 style="margin-top: 45px;padding: 11%;" class="msg-alert-filter text-center"><i class="fa fa-calendar-times-o"></i> Não foi encontrado Solicitações Recebidas para o projeto '+ $("#disabledSelect :selected").text() +'</h3></div>');
                }else{
                    $("#spm").html('<div class="informative"><h3 style="margin-top: 45px;padding: 11%;" class="msg-alert-filter text-center"><i class="fa fa-calendar-times-o"></i> Não foi encontrado Solicitações Recebidas para o ano de '+ ano + '</h3></div>');
                }
                return;
            }
            c3.generate({
                bindto: '#cano',
                data: {
                    columns: response,
                    type: 'bar'
                },

                color: function (color, d) {
                    console.log(color, d);
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: ['Jan/' + currentYear, 'Fev/' + currentYear, 'Mar/' + currentYear, 'Abr/' + currentYear, 'Mai/' + currentYear, 'Jun/' + currentYear, 'Jul/' + currentYear, 'Ago/' + currentYear, 'Set/' + currentYear, 'Out/' + currentYear, 'Nov/' + currentYear, 'Dez/' + currentYear]
                    }
                }
            });

        }
    });
}


function filterMes(){
    $.ajax({
        type: "GET",
        dataType: 'json',
        url: urlBase + "informativo/getDayConsultas",
        data: $("#form-informativo").serialize(),
        success: function(response){
            if(response.length === 0){
                var mes = $("#disabledSelectMeses :selected").text();
                if(mes === 'Selecione'){
                    $("#sed").html('<div class="informative"><h3 style="margin-top: 45px;padding: 11%;" class="msg-alert-filter text-center"><i class="fa fa-calendar-times-o"></i> Não foi encontrado Solicitações Recebidas para o mes Atual '+ $("#disabledSelect :selected").text() +'</h3></div>');
                }else {
                    $("#sed").html('<div class="informative"><h3 style="margin-top: 45px;padding: 11%;" class="msg-alert-filter text-center"><i class="fa fa-calendar-times-o"></i>  Não foi encontrado Solicitações Recebidas para o mês Atual </h3></div>');
                }
                return;
            }
            c3.generate({
                bindto: '#sed',
                data: {
                    columns: response
                },
                axis: {
                    x: {
                        type: 'category',
                        categories: categories
                    }
                }
            });
        }
    });
}

function compareceu(consulta, paciente, idPaciente){
    swal({
        title: 'Comparecimento',
        html: "O Paciente " + '<strong>' + paciente + '</strong>' + " Compareceu?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00cebc",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        cancelButtonColor: "#222d32",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.value === true) {
            $("#id_consulta").val(consulta);
            $("#id_paciente").val(idPaciente);
            var compareceu = true;

            $.ajax({
                type: 'POST',
                url: urlBase + "consulta/compareceu/" + compareceu,
                data: $("#form-delete-consulta").serialize(),
                success: function (data) {
                    if(data.success === true){
                        setTimeout(function () {
                            swal({
                                title: data.msg,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then((result) => {
                                location.reload();
                            });
                        });
                    }else{
                        location.reload();
                    }
                }
            })
        }
    });
}

function naocompareceu(consulta, paciente, idPaciente) {
    swal({
        title: 'Excluir Consulta',
        html: "O Paciente " + '<strong>' + paciente + '</strong>' + " não compareceu? Deseja enviar um email?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#00cebc",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        cancelButtonColor: "#222d32",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if (result.value === true) {
            $("#id_consulta").val(consulta);
            $("#id_paciente").val(idPaciente);

            $.ajax({
                type: 'POST',
                url: urlBase + "consulta/deleteCday/",
                data: $("#form-delete-consulta").serialize(),
                success: function (data) {
                    if(data.success === true){
                        setTimeout(function () {
                            swal({
                                title: data.msg,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then((result) => {
                                location.reload();
                            });
                        });
                    }else{
                        location.reload();
                    }
                }
            })
        }
    });
}

function exportarExcel() {
    window.location = urlBase + 'consulta/export/excel?' + $("#form-avancado").serialize();
}