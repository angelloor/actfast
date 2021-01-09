
var url = "controlador/login.controlador.php";

$(document).ready(function() {
    
})

function enter(valor){
    if (valor == 1) {
        input = document.getElementById("usuario");
        input.addEventListener('keypress', logKey);
    }else{
        input = document.getElementById("clave");
        input.addEventListener('keypress', logKey);
    }
    function logKey(e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if(keycode == 13 ){
            iniciarSesion();
        }
    }
}

function iniciarSesion(){
    let usuario, clave;
    usuario = document.getElementById("usuario").value;
    clave = document.getElementById("clave").value;
    if(usuario == ""){
        Swal.fire("","Ingrese el usuario","info");
        return;
    }
    if(clave == ""){
        Swal.fire("","Ingrese la contraseña","info");
        return;
    }
    $.ajax({
        data: { "accion": "LOGIN", "usuario": usuario, "clave": clave},
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response == "OK") {
                window.location.href = "vista/index.php";
        } else {
            MostrarAlerta("", response, "error");
        }
    }).fail(function(response) {
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


