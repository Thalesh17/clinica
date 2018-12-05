// GET RESPONSE CONTROLLER


function responseType(redirect){
    // GET TYPE ERROR( NOTREDIRECT, WARNING, FAIL, OR SUCCESS )
    var RESPONSE_TYPE    = $("input[name=response_type]").val();
    // GET MESSAGE
    var RESPONSE_MESSAGE = $("input[name=response_message]").val();

    if(RESPONSE_TYPE == "FAIL"){
        swal({
            title: RESPONSE_MESSAGE,
            type: "error",
            timer: 3000,
            showConfirmButton: false
        });
    }else if(RESPONSE_TYPE == "NOTREDIRECT"){
        swal({
            title: RESPONSE_MESSAGE,
            type: "success",
            timer: 3000,
            showConfirmButton: false
        });
    }else if(RESPONSE_TYPE == "WARNING"){
        swal({
            title: RESPONSE_MESSAGE,
            type: "warning",
            timer: 3000,
            showConfirmButton: true
        });
    }else if(RESPONSE_TYPE == "SUCCESS"){
        swal({
            title: RESPONSE_MESSAGE,
            type: "success",
            timer: 3000,
            showConfirmButton: false
        }).then((result) => {
            window.location = urlBase + redirect;
        });
    }
}

function showAlert(type, message) {
    $('#alert').removeClass().addClass('alert-' + type).html(message).fadeIn();
    document.getElementById("alert").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin: 3px 5px;" onclick="closeAlert()"></i>' + message;
    setTimeout("closeAlert()", 4000); // 5 segundos
}

function showAlertModal(type, message, subModal = false, subModalChild = false) {

    if (subModal) {
        $('#alert-modal2').removeClass().addClass('alert-' + type).html(message).fadeIn();
        document.getElementById("alert-modal2").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin-right: 5px;" onclick="closeAlertModal()"></i>' + message;
        setTimeout("closeAlertModal(true, false)", 4000);
    } else if (subModalChild) {
        $('#alert-modal3').removeClass().addClass('alert-' + type).html(message).fadeIn();
        document.getElementById("alert-modal3").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin-right: 5px;" onclick="closeAlertModal()"></i>' + message;
        setTimeout("closeAlertModal(false, true)", 4000);
    } else {
        $('#alert-modal').removeClass().addClass('alert-' + type).html(message).fadeIn();
        document.getElementById("alert-modal").innerHTML = '<i class="fa fa-fw fa-close" style="float: right; margin-right: 5px;" onclick="closeAlertModal()"></i>' + message;
        setTimeout("closeAlertModal()", 4000); // 5 segundos
    }
}

function closeAlert() {
    $('#alert').fadeOut();
}

function closeAlertModal(subModal = false, subModalChild = false) {
    if (subModal) {
        $('#alert-modal2').fadeOut();
    } else if (subModalChild) {
        $('#alert-modal3').fadeOut();
    } else {
        $('#alert-modal').fadeOut();
    }
}

function closeAlertIndex() {
    $('#alert-index').fadeOut();
}

function abrirImagemFullScreen(indice, tipo, id) {

    waitingDialog.show('Procurando Imagens...');

    var pswpElement = document.querySelectorAll('.pswp')[0];

    var srcs = [];
    var items = [];

    $.ajax({
        type: "GET",
        url: urlBase + tipo + "/imagens/" + id,
        async: false,
        success: function (data) {
            srcs = data;
        }
    });

    srcs.forEach(function (path) {
        items.push({src: path, w: 0, h: 0});
    });

    var options = {
        index: indice
    };

    waitingDialog.hide();
    // Initializes and opens PhotoSwipe
    var gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

    gallery.listen('imageLoadComplete', function(index, item) {
        if (item.w < 1 || item.h < 1) {
            var img = new Image();
            img.onload = function() { // will get size after load
                item.w = this.width; // set image width
                item.h = this.height; // set image height
                gallery.invalidateCurrItems(); // reinit Items
                gallery.updateSize(true); // reinit Items
            }
            img.src = item.src; // let's download image
        }
    });

    gallery.init();
    gallery.currItem.src = srcs[indice];
}

function onTopModal() {
    $('.modal-body').animate({scrollTop: 0}, 1000, 'linear');
}

var waitingDialog = waitingDialog || (function ($) {
    'use strict';

    // Creating modal dialog's DOM
    var $dialog = $(
        '<div class="modal fade" data-backdrop="static" data-keyboard="false" role="dialog" aria-hidden="true" style="z-index: 99999;padding-top:15%; overflow-y:visible;">' +
        '<div class="modal-dialog modal-m">' +
        '<div class="modal-content">' +
        '<div class="modal-header"><h3 style="margin:0;"></h3></div>' +
        '<div class="modal-body">' +
        '<div class="progress progress-striped active" style="margin-bottom:0;"><div class="progress-bar" style="width: 100%"></div></div>' +
        '</div>' +
        '</div></div></div>');

    return {
        /**
         * Opens our dialog
         * @param message Custom message
         * @param options Custom options:
         *          options.dialogSize - bootstrap postfix for dialog size, e.g. "sm", "m";
         *          options.progressType - bootstrap postfix for progress bar type, e.g. "success", "warning".
         */
        show: function (message, options) {
            // Assigning defaults
            if (typeof options === 'undefined') {
                options = {};
            }
            if (typeof message === 'undefined') {
                message = 'Carregando...';
            }
            var settings = $.extend({
                dialogSize: 'm',
                progressType: '',
                onHide: null // This callback runs after the dialog was hidden
            }, options);

            // Configuring dialog
            $dialog.find('.modal-dialog').attr('class', 'modal-dialog').addClass('modal-' + settings.dialogSize);
            $dialog.find('.progress-bar').attr('class', 'progress-bar');
            if (settings.progressType) {
                $dialog.find('.progress-bar').addClass('progress-bar-' + settings.progressType);
            }
            $dialog.find('h3').text(message);
            // Adding callbacks
            if (typeof settings.onHide === 'function') {
                $dialog.off('hidden.bs.modal').on('hidden.bs.modal', function (e) {
                    settings.onHide.call($dialog);
                });
            }
            // Opening dialog
            $dialog.modal();
        },
        /**
         * Closes dialog
         */
        hide: function () {
            $dialog.modal('hide');
        }
    };

})(jQuery);

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition, showError);

    } else {
        $.confirm({
            title: 'Erro!',
            content: 'Geolocation is not supported by this browser.',
            type: 'red',
            typeAnimated: true,
            buttons: {
                close: {
                    text: 'Ok',
                    btnClass: 'btn-red',
                    action: function () {
                    }
                }
            }
        });
    }
}

function showError(error) {
    var msg = "";
    switch(error.code)
    {
        case error.PERMISSION_DENIED:
            msg = "Usuário rejeitou a solicitação de Geolocalização.";
            break;
        case error.POSITION_UNAVAILABLE:
            msg = "Localização indisponível.";
            break;
        case error.TIMEOUT:
            msg = "O tempo da requisiçao expirou.";
            break;
        case error.UNKNOWN_ERROR:
            msg = "Algum erro desconhecido aconteceu.";
            break;
    }

    $.confirm({
        title: 'Erro!',
        content: msg,
        type: 'red',
        typeAnimated: true,
        buttons: {
            close: {
                text: 'Ok',
                btnClass: 'btn-red',
                action: function(){
                    $('#endereco').removeAttr('readonly');
                    $('#numero').removeAttr('readonly');
                    $('#bairro').removeAttr('readonly');
                    $('#cidade').removeAttr('readonly');
                }
            }
        }
    });
}





function getDateAtual(){
    var date = new Date();
    var data;
    if(date.getDate() < 10 && date.getMonth() < 10){
        data = date.getFullYear()+'-0'+(date.getMonth()+1)+'-0'+date.getDate();
    }else if(date.getDate() < 10 && date.getMonth() > 10){
        data = date.getFullYear()+'-'+(date.getMonth()+1)+'-0'+date.getDate();
    }else if(date.getDate() > 10 && date.getMonth() < 10){
        data = date.getFullYear()+'-0'+(date.getMonth()+1)+'-'+date.getDate();
    }else if(date.getDate() > 10 && date.getMonth() > 10){
        data = date.getFullYear()+'-'+(date.getMonth()+1)+'-'+date.getDate();
    }

    return data;

}

function somenteNumeros(e) {
    var tecla = e.which || e.keyCode;

    if(tecla >= 48 && tecla <= 57)
    {
        return true;
    }
    else
    {
        return false;
    }
}

function sortSelect(idSelect) {

    $('#' + idSelect + ' option[value="0"]').remove();
    var itensOrdenados = $('#' + idSelect + ' option').sort(function (a, b) {
        return a.text < b.text ? -1 : 1;
    });
    $('#' + idSelect).html(itensOrdenados);
    $('#' + idSelect).prepend('<option value="0" selected>Selecione</option>');
}

function daysInThisMonth() {
    var now = new Date();
    return new Date(now.getFullYear(), now.getMonth()+1, 0).getDate();
}

