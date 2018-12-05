$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip();

    if($("input[name=response_redirect]").val() == ""){
        responseType("usuario/profile");
    }else{
        responseType("usuario/profile");
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


    $("#content-modal-usuario").on("submit", "#form-usuario",function(event){
        event.preventDefault();
        waitingDialog.show('Salvando...');

        document.getElementById("salvar-usuario").disabled = true;

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "usuario/store",
            data: $("#form-usuario").serialize(),
            success: function(data){
                if (data.success === true) {
                    $('#modal-form-usuario').modal('toggle');
                    setTimeout(function(){
                        swal({
                            title: 'Usuários',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }, 600);
                    // showAlertModal('success', data.msg);
                    // setTimeout(function(){
                    //     $('#modal-form').modal('toggle');
                    //     location.reload();
                    // }, 1000);
                }else{
                    document.getElementById("salvar-usuario").disabled = false;
                    showAlertModal('warning', data.msg);
                }
                waitingDialog.hide();
            }
        });
    });

    $("#content-modal-usuario").on("click", "#add-funcao", function()
    {
        var idFuncao = $("#funcao-option").val(), textFuncao = $("#funcao-option :selected").text(), funcoes = getFuncoes(), adicionar = true;

        if(idFuncao != '')
        {
            funcoes.forEach(function(item, index) {
                if(item.funcao == idFuncao && item.deletar == false)
                {
                    showAlertModal('warning', "Função já existente na lista.");
                    adicionar = false;
                }
            });

            if(adicionar == true)
            {
                addFuncao(funcoes, 0, idFuncao, textFuncao, false);
            }

            $("#funcao-option").val(0).change();
        }
    });


    $("#change-profile-form").on("submit",function(event){
        event.preventDefault();
        waitingDialog.show('Salvando...');

        document.getElementById("salvar-change-profile").disabled = true;

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "usuario/profile/change",
            data: $("#change-profile-form").serialize(),
            success: function(data){
                if (data.success === true) {

                    setTimeout(function(){
                        swal({
                            title: 'Usuários',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }, 600);
                    // showAlert('success', data.msg);
                    // setTimeout(function(){
                    //     location.reload();
                    // }, 1500);
                }else{
                    document.getElementById("salvar-change-profile").disabled = false;
                    showAlert('warning', data.msg);
                }
                waitingDialog.hide();
            }
        });
    });
});

function inserirUsuario(){
    $.get(urlBase + 'usuario/create', function (resposta) {
        $("#content-modal-usuario").html(resposta);
        $('#modal-form-usuario').modal('show');
    });
}

function editarUsuario(id){
    $.get(urlBase + "usuario/edit/" + id, function(resposta){
        $("#content-modal-usuario").html(resposta);
        $('#modal-form-usuario').modal('show');
    });
}

function deletarUsuario (id, nome){
    swal({
        title: 'Excluir Usuários',
        html: 'Deseja realmente excluir o usuário <b>' + nome + '</b>?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if(result.value){
            waitingDialog.show('Salvando...');
            $.ajax({
                type: "POST",
                url: urlBase + "usuario/destroy",
                data: {_token: _token, id: id},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: 'Usuários',
                            text: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        swal("Usuários", data.msg , "error");
                    }
                    waitingDialog.hide();
                }, error: function(){
                    swal("Funções", 'Não é permitido a exclusão do Usuário.' , "error");
                }
            });
        }
    });
    // $.confirm({
    //     title: 'Excluir Usuários',
    //     content: 'Deseja realmente excluir a usuário <strong>' + nome + '</strong>?',
    //     buttons: {
    //         removerFuncao: {
    //             btnClass: 'btn-red',
    //             text: 'Sim',
    //             action: function () {
    //                 $.ajax({
    //                     type: "POST",
    //                     url: urlBase + "usuario/destroy",
    //                     data: {_token: _token, id: id},
    //                     success: function(data){
    //                         if (data.success == true) {
    //                             showAlert('success', data.msg);
    //                             setTimeout(function(){ location.reload(); }, 1000);
    //                         }else{
    //                             showAlert('warning', data.msg);
    //                         }
    //                         waitingDialog.hide();
    //                     }, error: function(){
    //                         showAlert('warning', 'Não é permitido a exclusão do Usuário.');
    //                     }
    //                 });
    //             }
    //         },
    //         cancel: {
    //             text: 'Não',
    //             action: function() {return true;}
    //         }
    //     }
    // });
}

function addFuncao(funcoes, id, idFuncao, textFuncao, deletar)
{
    funcoes.push({ id: id, funcao: idFuncao, deletar: deletar });
    setFuncao(funcoes);
    $("#table-body-funcoes").append("<tr><td>"+ textFuncao +"</td><td style=\"width: 45px;\"><button type=\"button\" class=\"btn btn-danger btn-xs btn-flat\" onclick=\"deletarFuncao(this, '"+idFuncao+"');\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button></td></tr>");
}

function getFuncoes()
{
    var funcoes = $("#funcoes-values").val();
    if(funcoes)
    {
        return JSON.parse(funcoes);
    }else{
        return [];
    }
}

function setFuncao(funcoes)
{
    $("#funcoes-values").val(JSON.stringify(funcoes));
}

function loadFuncoes()
{
    var idUser = $("#id-user").val();

    if(idUser != '')
    {
        waitingDialog.show('Carregando funções do usuário...');

        $.ajax({
            type: "GET",
            url: urlBase + "usuario/get-funcoes/" + idUser,
            data: {},
            success: function(data){
                if(data)
                {
                    data.forEach(function(item, index) {
                        addFuncao(getFuncoes(), item.id, item.id,  item.description, false);
                    });
                }

                waitingDialog.hide();
            }, error: function(){
                waitingDialog.hide();
                showAlert('danger', 'Erro ao carregar Funções.');
            }
        });
    }
}

function deletarFuncao(element, idFuncao)
{
    var funcoes = getFuncoes();

    funcoes.forEach(function(item, index, object) {
        if(item.funcao == idFuncao)
        {
            if(item.id != '')
            {
                item.deletar = true;
            }else{
                object.splice(index, 1);
            }

            $(element).closest("tr").remove();
        }
    });

    setFuncao(funcoes);
}

