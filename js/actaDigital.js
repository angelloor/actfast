var url = "../controlador/actaDigital.controlador.php";

$(document).ready(function() {
    cargarSistemas();
    listarFuncionario();
})

function soloNumeros(){
    $('#periodo').keypress(function (event) {
      if (event.which < 48 || event.which > 57  || event.which == 9) {
        return false;
      }
    });

}

function cargarSistemas(){
    $.ajax({
        data: { "accion": "CARGARSISTEMAS" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        var html = "";
        $.each(response, function(index, data) {
            html += '<div class="form-check"></div>';
            html += '<input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">';
            html += '<label class="form-check-label" for="flexCheckDefault">';
            html += data.nombre_sistema;
            html += '</label>';
            html += '</div>';
        });
        document.getElementById("sistemas").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}


function listarFuncionario(){
    $.ajax({
        data: { "accion": "LISTARFUNCIONARIO" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_PERSONA + "</option>";
        });
        document.getElementById("idPersona").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}