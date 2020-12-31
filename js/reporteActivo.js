var url = "../controlador/reporteActivo.controlador.php";

$(document).ready(function() {
    
})

function listarCategoria(){
    $.ajax({
        data: { "accion": "LISTARCATEGORIA" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "<option>" + " *  " + "</option>";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_CATEGORIA + "</option>";
        });
        document.getElementById("categoria").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}
