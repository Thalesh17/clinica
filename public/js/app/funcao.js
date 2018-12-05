$(document).ready(function() {

    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });

    $("#content-modal-funcao").on("click", "#add-permissao", function()
    {
        var idPermissao = $("#permissao-option").val();
        var textPermissao = $("#permissao-option :selected").text();
        var permissoes = getPermissoes();
        var adicionar = true;

        if(idPermissao != "" && idPermissao != 0)
        {
            permissoes.forEach(function(item, index) {
                if(item.permissao == idPermissao && item.deletar == false)
                {
                    showAlertModal('warning', "Permissão já existente na lista.");
                    adicionar = false;
                }
            });

            if(adicionar == true)
            {
                addPermissao(permissoes, 0, idPermissao, textPermissao,  false);
                $("#permissao-option :selected").remove();
            }
            $("#permissao-option").val(0).change();
        }
        else{
            swal({
                title: 'Permissões',
                html: 'Permissão não selecionada.',
                type: "warning",
                timer: 800,
                showConfirmButton: false
            });
        }
    });

    $("#content-modal-funcao").on("submit", "#form-funcao",function(event){
        event.preventDefault();


        document.getElementById("salvar-funcao").disabled = true;

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "funcao/store",
            data: $("#form-funcao").serialize(),
            success: function(data){
                if (data.success === true) {
                    $('#modal-form-funcao').modal('toggle');
                    setTimeout(function(){
                        swal({
                            title: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }, 600);
                }else{
                    document.getElementById("salvar-funcao").disabled = false;
                    var erros = data.msg;
                    var keys = Object.keys(erros);
                    validateErrors(erros, keys, 'danger');

                }

            }
        });
    });
});

// $(function() {
//     $("#filtro").keyup(function() {
//       $("#body-post p").css("display", "block");
//       var texto = $(this).val().toUpperCase();
//       $("#body-post table tr").css("display", "block");
//       $("#body-post table tr td").css("display", "block");
//       $("#body-post tr").each(function() {
//         if ($(this).text().toUpperCase().indexOf(texto) < 0)
//           $(this).css("display", "none");
//       });
//     });

//     $("#rst").on("click", function(){
//       $("#body-post").css("display", "block");
//       $("#filtro").focus();
//     });
//   });


function inserirFuncao(){
    $.get(urlBase + 'funcao/create', function (resposta) {
        $("#content-modal-funcao").html(resposta);
        $('#modal-form-funcao').modal('show');
        $(".select2").select2({language: 'pt-BR'});
    });
}

function editarFuncao(id){
    $.get(urlBase + "funcao/edit/" + id, function(resposta){
        $("#content-modal-funcao").html(resposta);
        $('#modal-form-funcao').modal('show');
        $(".select2").select2({language: 'pt-BR'});
    });
}

function deletarFuncao (id, descricao){

    swal({
        title: 'Excluir Funções',
        html: 'Deseja realmente excluir a Função <b>' + descricao + '</b>?',
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: true
    }).then((result) => {
        if(result.value){
            $.ajax({
                type: "POST",
                url: urlBase + "funcao/destroy",
                data: {_token: _token, id: id},
                success: function(data){
                    if (data.success == true) {
                        swal({
                            title: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }else{
                        swal("Funções", data.msg , "error");
                    }
                    waitingDialog.hide();
                }, error: function(){
                    swal("Funções", 'Não é permitido a exclusão da Função.' , "error");
                }
            }).fail(function(resposta) {
                if(resposta.status == 401){
                    swal("Funções", "Sem permissão para acessar essa funcionalidade." , "error");
                }
            });
        }
    });

    // $.confirm({
    //     title: 'Excluir Funções',
    //     content: 'Deseja realmente excluir a função <strong>' + descricao + '</strong>?',
    //     buttons: {
    //         removerFuncao: {
    //             btnClass: 'btn-red',
    //             text: 'Sim',
    //             action: function () {
    //                 $.ajax({
    //                     type: "POST",
    //                     url: urlBase + "funcao/destroy",
    //                     data: {_token: _token, id: id},
    //                     success: function(data){
    //                         if (data.success == true) {
    //                             swal({
    //                                     title: 'Funções',
    //                                     text: data.msg,
    //                                     type: "success",
    //                                     timer: 2000,
    //                                     showConfirmButton: false
    //                                 },
    //                                 function () {
    //                                     location.reload();
    //                                 });
    //                             // showAlert('success', data.msg);
    //                             // setTimeout(function(){ location.reload(); }, 1000);
    //                         }else{
    //                             showAlert('warning', data.msg);
    //                         }
    //                         waitingDialog.hide();
    //                     }, error: function(){
    //                         showAlert('warning', 'Não é permitido a exclusão da Função.');
    //                     }
    //                 }).fail(function(resposta) {
    //                     if(resposta.status == 401){
    //                         showAlert('warning', "Sem permissão para acessar essa funcionalidade.");
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

function addPermissao(permissoes, id, idPermissao, textPermissao, deletar)
{
    permissoes.push({ id: id, permissao: idPermissao, deletar: deletar });
    setPermissao(permissoes);

    $("#table-body-permissoes").append("<tr><td>"+ textPermissao +"</td><td style=\"width: 45px;\"><button type=\"button\" class=\"btn btn-cust-danger btn-xs btn-flat\" onclick=\"deletarPermissao(this, '"+idPermissao+"');\"><span class=\"glyphicon glyphicon-trash\" aria-hidden=\"true\"></span></button></td></tr>");
}

function getPermissoes()
{
    var permissoes = $("#permissoes-values").val();
    if(permissoes)
    {
        return JSON.parse(permissoes);
    }else{
        return [];
    }
}

function setPermissao(permissoes)
{
    console.log(permissoes);
    $("#permissoes-values").val(JSON.stringify(permissoes));
}

function deletarPermissao(element, idPermissao)
{
    var permissoes = getPermissoes();
    var textSelectBack = ($(element).parent().parent().find('td')[0]);
    var returnCombobox = false;
    permissoes.forEach(function(item, index, object) {
        if (item.permissao == idPermissao){

            if (returnCombobox != true) {
                $('#permissao-option').append($('<option>', {
                    value: item.permissao,
                    text: $(textSelectBack).html()
                }));
                returnCombobox = true;
            }

            if (item.id > 0) {
                item.deletar = true;

            }else{
                object.splice(index, 1);
            }

            $(element).closest("tr").remove();
            sortSelect('permissao-option');

        }

    });
    setPermissao(permissoes);
}

function loadPermissoes()
{
    var idRole = $('#id-role').val();

    if (idRole > 0){
        $.ajax({
            type: "GET",
            url: urlBase + "funcao/get-permissoes/" + idRole,
            data: {},
            success: function(data){
                if (data != null) {
                    data.forEach(function(item, index) {
                        addPermissao(getPermissoes(), item.id, item.permission_id,  item.description, false);
                        $('#permissao-option option[value="' + item.permission_id + '"]').remove();
                    });
                }
            }, error: function(){
                showAlert('danger', 'Erro ao carregar Funções.');
            }
        });
    }
}
