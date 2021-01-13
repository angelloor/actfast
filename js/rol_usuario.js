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
            html += "<td class='padding-ru'>" + data.nombre_rol_usuario + "</td>";
            html += "<td class='padding-ru'>" + data.descripcion_rol_usuario + "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}
