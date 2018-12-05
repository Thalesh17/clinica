var skin_change = "";
$(document).ready(function() {
    $('#cnpj').inputmask({'mask': "99.999.999/9999-99", greedy: false, reverse: false, autoUnmask: true});
    $('#cep').inputmask({'mask': "99999-999", greedy: false, reverse: true, autoUnmask: true});
    $('#telefone').inputmask({'mask': "(99) 9999-9999", greedy: false, reverse: true, autoUnmask: true});
    $('#celular').inputmask({'mask': "(99) 99999-9999", greedy: false, reverse: true, autoUnmask: true});
    $('#numero').inputmask({'mask': "99999", greedy: false, reverse: true, autoUnmask: true});
    $('#sigla').inputmask({'mask': "###", greedy: false, reverse: true, autoUnmask: true});

    // $('.change-skin-layout').on("click", function () {
    //     waitingDialog.show('Carregando...');
    //     var skinAnt = $('body').attr("class");
    //     skinAnt = skinAnt.split(" ");
    //     var skin = $(this).find('a').attr('data-skin');
    //     var classe = skin + " ";
    //     for (i = 1; i < skinAnt.length; i++) {
    //         classe += skinAnt[i] + " ";
    //     }
    //     $('body').removeClass().addClass(classe);
    //     $('header nav').removeClass(skinAnt[0] + "-pattern").addClass(skin + "-pattern");
    //     $("input[name=skin]").val(skin);
    //     $('body, html').animate({scrollTop: 0}, 500);
    //     waitingDialog.hide();
    // });


    $("#form-configuracao").on("submit",function(event){
        event.preventDefault();
        waitingDialog.show('Carregando...');
        //desabilitar quando for enviado a requisicao
        document.getElementById("salvar-configuracao").disabled = true;
        var formData = new FormData(this);

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: urlBase + "configuracao/store",
            data: formData,
            cache:false,
            contentType: false,
            processData: false,
            success: function(data){
                if (data.success === true) {
                    $('html,body').animate({scrollTop: 0},'slow');
                    setTimeout(function(){
                        swal({
                            title: 'Configuração',
                            html: data.msg,
                            type: "success",
                            timer: 2000,
                            showConfirmButton: false
                        }).then((result) => {
                            location.reload();
                        });
                    }, 600);

                }else{
                    $('html,body').animate({scrollTop: 0},'slow');
                    document.getElementById("salvar-configuracao").disabled = false;
                    setTimeout(function(){
                        swal({
                            title: 'Configuração',
                            html: data.msg,
                            type: "warning",
                            timer: 2000,
                            showConfirmButton: false
                        });
                    }, 600);
                }
                waitingDialog.hide();
            }
        });
    });
});