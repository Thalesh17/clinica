$(document).ready(function () {

    $("#add-especialidade").click(function () {
        var idEspecialidade = $("#especialidade-select").val();
        var nomeEspecialidade = $("#especialidade-select :selected").text();
        var especialidades = getEspecialidades();
        var add = true;

        if (idEspecialidade > 0) {
            especialidades.forEach(function (item, index) {
                if(item.especialidade === idEspecialidade && item.deletar === false) {
                    showAlert('warning', "Especialidade já existe na lista.");
                    $('body, html').animate({scrollTop : 0},500);
                    adicionar = false;
                }
            });


            if (add === true) {
                addEspecialidade(especialidades, 0, idEspecialidade, nomeEspecialidade, false)
                $("#especialidade-select :selected").remove();
            }

            $("#especialidade-select").val(0).change();
        }else{
            swal({
                title: 'Especialidade',
                html: 'Selecione uma Especialidade.',
                type: "warning",
                timer: 800,
                showConfirmButton: false
            })
        }

    })
});

function getEspecialidades() {
    var especialidades = $("#especialidade-val").val();

    if(especialidades){
        return JSON.parse(especialidades);
    }else {
        return [];
    }
}

function setEspecialidade(especialidades)
{
    $("#especialidade-val").val(JSON.stringify(especialidades));
}


function addEspecialidade(especialidades, id, idEspecialidade, nomeEspecialidade, deletar)
{
    especialidades.push({ id: id, especialidade: idEspecialidade, deletar: deletar });
    setEspecialidade(especialidades);
    var newRow = '<tr><td>'+ nomeEspecialidade +'</td>';
    newRow+= '<td style="width: 45px;"><button type="button" data-toggle="tooltip" title="Deletar" class="btn btn-cust-danger btn-xs" onclick="deletarEspecialidade(this, '+idEspecialidade+');"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button></td>';
    newRow+= '</tr>'
    $("#table-body-especialidade").append(newRow);
    $('[data-toggle="tooltip"]').tooltip({ trigger: "hover" });

}

function deletarEspecialidade(element, idEspecialidade) {
    var especialidades = getEspecialidades();
    var textBack = ($(element).parent().parent().find('td')[0]);
    var returnCombobox = false;

    especialidades.forEach(function(item, index, object){
        if(item.especialidade == idEspecialidade){
            if(returnCombobox != true){
                $('#especialidade-select').append($('<option>',{
                    value: item.especialidade,
                    text: $(textBack).html()
                }));
                returnCombobox = true;
            }

            if (item.id > 0) {
                item.deletar = true;

            }else{
                object.splice(index, 1);
            }

            $(element).closest("tr").remove();
            sortSelect('especialidade-select');
        }
    });
    setEspecialidade(especialidades);
}