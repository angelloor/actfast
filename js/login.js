
var url = "controlador/login.controlador.php";

$(document).ready(function() {
    
})

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
        console.log(response);
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


