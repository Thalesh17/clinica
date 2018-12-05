$(document).ready(function () {

    $('[data-toggle="tooltip"]').tooltip();

    $("#content-modal-visualizar").on("click", "#fechar", function() {
        $('#modal-form-visualizar').modal('toggle');
    });

    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.avatar').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }


    $(".file-upload").on('change', function(){
        readURL(this);
    });

    $('#cpf').inputmask({'mask': ["999.999.999-99"], greedy: false, reverse: true, autoUnmask: true, keepStatic: true});
    $('#celular').inputmask({'mask': "(99) 99999-9999", greedy: false, reverse: true, autoUnmask: true});
    $('#telefone').inputmask({'mask': "(99) 9999-9999", greedy: false, reverse: true, autoUnmask: true});


    if($("input[name=response_redirect]").val() == ""){
        responseType("paciente/edit/"+$("input[name=id]").val());
    }else{
        responseType("paciente");
    }
});


function visualizar(id) {
    $.get(urlBase + "paciente/show/" + id, function (resposta) {
        $("#content-modal-visualizar").html(resposta);
        $('#modal-form-visualizar').modal('show');
    }).fail(function (resposta) {

    });
}


function editar(paciente) {
    window.location = urlBase + 'paciente/edit/' + paciente;
}

function deletar(id, paciente){
    swal({
        title: 'Excluir Paciente',
        html: 'Deseja realmente excluir a(o) Paciente <b>' + paciente + '</b>?',
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
                url: urlBase + "paciente/delete",
                data: {_token: _token, id: id, paciente: paciente},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: 'Paciente',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        swal("Paciente", data.msg , "error");
                    }
                },
            })
        }
    });
}

function exportarExcel() {
    window.location = urlBase + 'paciente/export/excel?' + $("#form-avancado").serialize();
}


