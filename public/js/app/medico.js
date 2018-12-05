$(document).ready(function () {
    $('[data-toggle="tooltip"]').tooltip();

    if($("input[name=response_redirect]").val() == ""){
        responseType("medico/edit/"+$("input[name=id]").val());
    }else{
        responseType("medico");
    }

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

});


function visualizar(id) {
    $.get(urlBase + "medico/show/" + id, function (resposta) {
        $("#content-modal-visualizar").html(resposta);
        $('#modal-form-visualizar').modal('show');
    }).fail(function (resposta) {

    });
}


function editar(medico) {
    window.location = urlBase + 'medico/edit/' + medico;
}


function deletar(id, medico) {
        swal({
            title: 'Excluir Paciente',
            html: 'Deseja realmente excluir a(o) Médico <b>' + medico + '</b>?',
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
                    url: urlBase + "medico/delete",
                    data: {_token: _token, id: id, medico: medico},
                    success: function(data){
                        if (data.success == true) {
                            swal({
                                title: 'Médico',
                                text: data.msg,
                                type: "success",
                                timer: 2000,
                                showConfirmButton: false
                            }).then((result) => {
                                location.reload();
                            });
                        }else{
                            swal("Médico", data.msg , "error");
                        }
                    },
                })
            }
        });
}

function exportarExcel() {
    window.location = urlBase + 'medico/export/excel?' + $("#form-avancado").serialize();
}