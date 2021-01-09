var url = "../controlador/activosConfirmados.controlador.php";
var registrosTotales = false;

$(document).ready(function() {
    consultar();
})

function consultar(){
    registrosTotales = false;
    $.ajax({
        data: { "accion": "CONSULTAR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response.length >= 1) {
            registrosTotales = true;
        }
        var html = "";
        $.each(response, function(index, data) {
            html += "<tr>";
            html += "<td>" + data.codigo + "</td>";
            html += "<td>" + data.nombre_activo + "</td>";
            html += "<td>" + data.caracteristica + "</td>";
            html += "<td>" + data.nombre_marca + "</td>";
            html += "<td>" + data.modelo + "</td>";
            html += "<td>" + data.serie + "</td>";
            html += "<td>" + data.nombre_estado + "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function pdf(){
    accion = "pdf";
    if (registrosTotales == false) {
        MostrarAlerta("","No se encuentra activos confirmados","info");
        return;
    }else{
        window.open('../modelo/activosConfirmados.php?accion='+accion, '_blank');
    }
}

function excel(){
    accion = "excel";
    if (registrosTotales == false) {
        MostrarAlerta("","No se encuentra activos confirmados","info");
        return;
    }else{
        window.open('../modelo/activosConfirmados.php?accion='+accion, '_blank');
    }
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}