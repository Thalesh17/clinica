$(document).ready(function () {

    $("#content-modal-tipo-sanguineo").on("click", "#fechar", function() {
        $('#modal-form-tipo-sanguineo').modal('toggle');
    });

    $('[data-toggle="tooltip"]').tooltip();

    $("#content-modal-tipo-sanguineo").on("submit", "#form-tipo-sanguineo",function(event){

        event.preventDefault();

        document.getElementById("salvar").disabled = true;

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "tipo-sanguineo/store",
            data: $("#form-tipo-sanguineo").serialize(),
            success: function(data){
                if (data.success === true) {
                    $('#modal-form-tipo-sanguineo').modal('toggle');
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
    $.get(urlBase + "tipo-sanguineo/edit/" + id, function(resposta){
        $("#content-modal-tipo-sanguineo").html(resposta);
        $('#modal-form-tipo-sanguineo').modal('show');
    }).fail(function(resposta) {

    });}


function adicionar() {
    $.get(urlBase + "tipo-sanguineo/create/", function(resposta){
        $("#content-modal-tipo-sanguineo").html(resposta);
        $('#modal-form-tipo-sanguineo').modal('show');
    }).fail(function(resposta) {

    });}

function deletar(id, descricao){

    swal({
        title: 'Excluir Tipo Sanguíneo',
        html: 'Deseja realmente excluir o Tipo Sanguíneo <b>' + descricao + '</b>?',
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
                url: urlBase + "tipo-sanguineo/delete",
                data: {_token: _token, id: id},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: 'Tipo Sanguíneo',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        swal("Tipo Sanguíneo", data.msg , "error");
                    }
                },
            })
        }
    });
}