var url = "../controlador/reporteActivo.controlador.php";

$(document).ready(function() {
    listarCategoria();
    listarMarca();
    listarEstado();
    listarCustodio();
    listarFuncionario();
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

function listarMarca(){
    $.ajax({
        data: { "accion": "LISTARMARCA" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "<option>" + " *  " + "</option>";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_MARCA + "</option>";
        });
        document.getElementById("marca").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function listarEstado(){
    $.ajax({
        data: { "accion": "LISTARESTADO" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "<option>" + " *  " + "</option>";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_ESTADO + "</option>";
        });
        document.getElementById("estado").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function listarCustodio(){
    $.ajax({
        data: { "accion": "LISTARCUSTODIO" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "<option>" + " *  " + "</option>";
        $.each(response, function(index, data) {
            html += "<option>" + data.nombre_persona + "</option>";
        });
        document.getElementById("custodio").innerHTML = html;
    }).fail(function(response){
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
        var html = "<option>" + " *  " + "</option>";
        $.each(response, function(index, data) {
            html += "<option>" + data.nombre_persona + "</option>";
        });
        document.getElementById("funcionario").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function Validar() {
    categoria = document.getElementById('categoria').value;
    marca = document.getElementById('marca').value;
    estado = document.getElementById('estado ').value
    custodio = document.getElementById('custodio').value 
    funcionario = document.getElementById('funcionario').value
    if (categoria == "" || marca == "" || estado == "" || custodio == "" || funcionario == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "categoria": document.getElementById('categoria').value,
        "marca": document.getElementById('marca').value,
        "estado": document.getElementById('estado').value,
        "custodio": document.getElementById('custodio').value,
        "funcionario": document.getElementById('funcionario').value,
        "accion": accion
    };
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}
