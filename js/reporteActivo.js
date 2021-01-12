var url = "../controlador/reporteActivo.controlador.php";
var urlGet = "";
var registrosTotales = false;
$(document).ready(function() {
    document.getElementById('campo').addEventListener('change', cagarValor, false);
    document.getElementById('valor').addEventListener('change', consultar, false);
    ocultarAlerta();
    cargarValor();
    cargaInicial();
})

function cargaInicial(){
    registrosTotales = false;
    $.ajax({
        data: { "accion": "CARGAINICIAL"},
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        if (response.length >= 1) {
            registrosTotales = true;
            ocultarAlerta();
        }else{
            mostrarAlertaDatos();
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
    }).fail(function(response){
        console.log(response);
    });
}

function mostrarAlertaDatos(){
    var alerta = document.getElementById('alerta');
    alerta.style.display = "block";
}

function ocultarAlerta(){
    var alerta = document.getElementById('alerta');
    alerta.style.display = "none";
}

function cargarValor(){
    $.ajax({
        data: { "accion": "CARGARVALOR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "<option>" + " *  " + "</option>";
        $.each(response, function(index, data) {
            html += "<option>" + data.nombre + "</option>";
        });
        document.getElementById("valor").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}
 
function cagarValor(){
    campo = document.getElementById('campo').value;
        $.ajax({
            data: { "accion": "LISTARVALOR", "campo": campo },
            url: url,
            type: 'POST',
            dataType: 'json'
        }).done(function(response){
            var html = "<option>" + " *  " + "</option>";
            $.each(response, function(index, data) {
                html += "<option>" + data.nombre + "</option>";
            });
            document.getElementById("valor").innerHTML = html;
        }).fail(function(response){
            console.log(response);
        });
}

function consultar(){
    registrosTotales = false;
    campo = document.getElementById('campo').value;
    valor = document.getElementById('valor').value;
    if (valor == "") {
        MostrarAlerta("","Tiene que seleccionar un campo para continuar","info")
    }else{
        $.ajax({
            data: { "accion": "CONSULTAR", "campo": campo, "valor": valor },
            url: url,
            type: 'POST',
            dataType: 'json'
        }).done(function(response){
            if (response.length >= 1) {
                registrosTotales = true;
                ocultarAlerta();
            }else{
                mostrarAlertaDatos();
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
        }).fail(function(response){
            console.log(response);
        });
    }
}

function pdf(){
    urlGet = "";
    campo = document.getElementById('campo').value;
    valor = document.getElementById('valor').value;
    accion = "pdf";
    if (valor == "") {
        MostrarAlerta("","Tiene que seleccionar un campo para continuar","info")
    }else{
        if (!registrosTotales) {
            MostrarAlerta("","No se encuentran registros de "+valor+" en "+campo,"info")
            return;
        }else{
            urlGet = urlGet+"campo="+campo+"&valor="+valor+"&accion="+accion;
            window.open('../modelo/reporteActivo.php?'+urlGet, '_blank');
        }
    }
}

function excel(){
    urlGet = "";
    campo = document.getElementById('campo').value;
    valor = document.getElementById('valor').value;
    accion = "excel";
    if (valor == "") {
        MostrarAlerta("","Tiene que seleccionar un campo para continuar","info")
    }else{
        if (!registrosTotales) {
            MostrarAlerta("","No se encuentran registros de "+valor+" en "+campo,"info")
            return;
        }else{
            urlGet = urlGet+"campo="+campo+"&valor="+valor+"&accion="+accion;
            window.open('../modelo/reporteActivo.php?'+urlGet, '_blank');
        }
    }
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}
