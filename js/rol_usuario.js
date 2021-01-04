var url = "../controlador/rol_usuario.controlador.php";

$(document).ready(function() {
    Consultar();
})

function Consultar() {
    $.ajax({
        data: { "accion": "CONSULTAR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        var html = "";
        $.each(response, function(index, data) {
            html += "<tr>";
            html += "<td>" + data.NOMBRE_ROL_USUARIO + "</td>";
            html += "<td>" + data.DESCRIPCION_ROL_USUARIO + "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}
