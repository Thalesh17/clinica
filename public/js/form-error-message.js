function validateErrors(erros, key, type) {
    var color = null;

    key.forEach(function (index) {
        if (type == 'warning') {
            color = '#db8b0b';
        }

        if (type == 'danger') {
            color = '#d33724';
        }

        if (type == 'orange') {
            color = '#ff7701 ';
        }

        $("form input[name=" + index + "]").css({
            "border": "solid 1px " + color + "",
            "color": "" + color + ""
        });

        $("form textarea[name=" + index + "]").css({
            "border": "solid 1px " + color + "",
            "color": "" + color + ""
        });

        $("form select[name=" + index + "]").css({
            "border": "solid 1px " + color + " ",
            "color": "" + color + ""
        });

        $("form select[name=" + index + "]").parent().find('.select2-selection').css({
            "border": "solid 1px " + color + " ",
            "color": "" + color + ""
        });
        
        if ($("form input[name=" + index + "]").length > 0){
            
            $("form input[name=" + index + "]").attr('data-toggle', "tooltip");
            $("form input[name=" + index + "]").attr('data-placement', "bottom");
            $("form input[name=" + index + "]").attr('data-original-title', erros[index]);
            $("form input[name=" + index + "]").unbind("focusin");
            
        }
        if ($("form select[name=" + index + "]")){
            
            $("form select[name=" + index + "]").attr('data-toggle', "tooltip");
            $("form select[name=" + index + "]").attr('data-placement', "bottom");
            $("form select[name=" + index + "]").attr('data-original-title', erros[index]);
            $("form select[name=" + index + "]").unbind("focusin");
        }
        
        if ($("form select[name=" + index + "]").parent().find('.select2-selection')){
            
            $("form select[name=" + index + "]").parent().find('.select2-selection').attr('data-toggle', "tooltip");
            $("form select[name=" + index + "]").parent().find('.select2-selection').attr('data-placement', "bottom");
            $("form select[name=" + index + "]").parent().find('.select2-selection').attr('data-original-title', erros[index]);
            $("form select[name=" + index + "]").parent().find('.select2-selection').unbind("focusin");
        }

        if ($("form textarea[name=" + index + "]").length > 0) {

            $("form textarea[name=" + index + "]").attr('data-toggle', "tooltip");
            $("form textarea[name=" + index + "]").attr('data-placement', "bottom");
            $("form textarea[name=" + index + "]").attr('data-original-title', erros[index]);
            $("form textarea[name=" + index + "]").unbind("focusin");

        }
        
        $("form input[name=" + index + "]").focusin(function () {
            $(this).removeAttr("style");           
            $(this).removeAttr("data-original-title");
            $(this).tooltip('destroy');
            $(this).unbind("focusin");
        });

        $("form textarea[name=" + index + "]").focusin(function () {

            $(this).removeAttr("style");
            $(this).removeAttr("data-original-title");
            $(this).tooltip('destroy');
            $(this).unbind("focusin");

        });

        $("form .checkboxFiveInput label").click(function(){
            $(this).parent().parent().parent().find("input[type=text]").focus();
        });

        $("form select[name=" + index + "]").focusin(function () {
            $(this).removeAttr("style");
            $(this).removeAttr("data-original-title");
            $(this).tooltip('destroy');
            $(this).unbind("focusin");
        });

        $("form select[name=" + index + "]").parent().find('.select2-selection').focusin(function () {
            $(this).removeAttr("style");
            $(this).parent().parent().parent().parent().find("label[for=" + index + "]").removeAttr("style");
            $(this).removeAttr("data-original-title");
            $(this).tooltip('destroy');
            $(this).unbind("focusin");
        });
    });

    $(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });

}

function simpleValidateErrors(name,msg, type) {
    var erros = {};
    erros[name] = [msg];
    var keys = Object.keys(erros);
    validateErrors(erros, keys, type);
}