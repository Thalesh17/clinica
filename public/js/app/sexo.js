$(document).ready(function () {

    $("#content-modal-sexo").on("click", "#fechar", function() {
        $('#modal-form-sexo').modal('toggle');
    });

    $('[data-toggle="tooltip"]').tooltip();

    $("#content-modal-sexo").on("submit", "#form-sexo",function(event){

        event.preventDefault();

        document.getElementById("salvar").disabled = true;

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "sexo/store",
            data: $("#form-sexo").serialize(),
            success: function(data){
                if (data.success === true) {
                    $('#modal-form-sexo').modal('toggle');
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

function editar(id) {
    $.get(urlBase + "sexo/edit/" + id, function(resposta){
        $("#content-modal-sexo").html(resposta);
        $('#modal-form-sexo').modal('show');
    }).fail(function(resposta) {

    });}


function adicionar() {
    $.get(urlBase + "sexo/create/", function(resposta){
        $("#content-modal-sexo").html(resposta);
        $('#modal-form-sexo').modal('show');
    }).fail(function(resposta) {

    });}

function deletar(id, descricao){

    swal({
        title: 'Excluir Sexo',
        html: 'Deseja realmente excluir o Sexo <b>' + descricao + '</b>?',
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
                url: urlBase + "sexo/delete",
                data: {_token: _token, id: id},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: 'Sexo',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        swal("Sexo", data.msg , "error");
                    }
                },
            })
        }
    });
}