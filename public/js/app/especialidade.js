$(document).ready(function () {

    $("#content-modal-especialidade").on("click", "#fechar", function() {
        $('#modal-form-especialidade').modal('toggle');
    });

    $('[data-toggle="tooltip"]').tooltip();

    $("#content-modal-especialidade").on("submit", "#form-especialidade",function(event){

        event.preventDefault();

        document.getElementById("salvar").disabled = true;

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "especialidade/store",
            data: $("#form-especialidade").serialize(),
            success: function(data){
                if (data.success === true) {
                    $('#modal-form-especialidade').modal('toggle');
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
    $.get(urlBase + "especialidade/edit/" + id, function(resposta){
        $("#content-modal-especialidade").html(resposta);
        $('#modal-form-especialidade').modal('show');
    }).fail(function(resposta) {

    });}


function adicionar() {
    $.get(urlBase + "especialidade/create/", function(resposta){
        $("#content-modal-especialidade").html(resposta);
        $('#modal-form-especialidade').modal('show');
    }).fail(function(resposta) {

});}

function deletar(id, descricao){

    swal({
        title: 'Excluir Especialidade',
        html: 'Deseja realmente excluir a Especialidade <b>' + descricao + '</b>?',
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
                url: urlBase + "especialidade/delete",
                data: {_token: _token, id: id},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: 'Especialidade',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        swal("Especialidade", data.msg , "error");
                    }
                },
            })
        }
    });
}