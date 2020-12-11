var url = "../controlador/usuario.controlador.php";

$(document).ready(function() {
    BloquearBotones(true);
    Consultar();
    EscucharConsulta();
    listarFuncionarios();
    listarRoles();
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
            html += "<td>" + data.id_usuario + "</td>";
            html += "<td>" + data.nombre_persona + "</td>";
            html += "<td>" + data.nombre_usuario + "</td>";
            html += "<td style='-webkit-text-security: disc;'>" + data.clave + "</td>";
            html += "<td>" + data.nombre_rol_usuario + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_usuario + ");'><span class='fa fa-edit'></span></button>"
            html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_usuario + ");'><span class='fa fa-trash'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function EscucharConsulta(){
    $('#idUsuario').keyup(function() {
        if($('#idUsuario').val()) {
          let idBuscar = $('#idUsuario').val();
          $.ajax({
            data: { "idBuscar": idBuscar, "accion": "CONSULTAR_ID_ROW" },
            url: url,
            type: 'POST',
            dataType: 'json'
            }).done(function(response) {
                console.log(response);
                var html = "";
                $.each(response, function(index, data) {
                    html += "<tr>";
                    html += "<td>" + data.id_usuario + "</td>";
                    html += "<td>" + data.nombre_persona + "</td>";
                    html += "<td>" + data.nombre_usuario + "</td>";
                    html += "<td style='-webkit-text-security: disc;'>" + data.clave + "</td>";
                    html += "<td>" + data.nombre_rol_usuario + "</td>";
                    html += "<td style='text-align: right;'>";
                    html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_usuario + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_usuario + ");'><span class='fa fa-trash'></span></button>"
                    html += "</td>";
                    html += "</tr>";
                });
                document.getElementById("datos").innerHTML = html;
            }).fail(function(response) {
                console.log(response);
            });
        }
      });
}

function listarFuncionarios(){
    $.ajax({
        data: { "accion": "LISTARFUNCIONARIOS" },
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

function listarRoles(){
    $.ajax({
        data: { "accion": "LISTARROLES" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_ROL_USUARIO + "</option>";
        });
        document.getElementById("rol").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function ConsultarPorId(idUsuario) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de modificar el usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                data: { "idUsuario": idUsuario, "accion": "CONSULTAR_ID" },
                type: 'POST',
                dataType: 'json'
            }).done(function(response) {
                document.getElementById('idPersona').value = response.nombre_persona;
                document.getElementById('nombre').value = response.nombre_usuario;
                document.getElementById('clave').value = response.clave;
                document.getElementById('rol').value = response.nombre_rol_usuario;
                document.getElementById('idUsuario').value = response.id_usuario;
                BloquearBotones(false);
            }).fail(function(response) {
                console.log(response);
            });
        } else if (
          result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire('','Operación Cancelada','info')
        }
      })   
}

function Guardar() {
    $.ajax({
        url: url,
        data: retornarDatos("GUARDAR"),
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos guardados con éxito", "success");
            Limpiar();
        } else {
            MostrarAlerta("Error!", response, "error");
        }
        Consultar();
    }).fail(function(response) {
        console.log(response);
    });
}

function Modificar() {
    $.ajax({
        url: url,
        data: retornarDatos("MODIFICAR"),
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos actualizados con éxito", "success");
            Limpiar();
        } else {
            MostrarAlerta("Error!", response, "error");
        }
        Consultar();
    }).fail(function(response) {
        console.log(response);
    });
}

function Eliminar(idUsuario) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de eliminar el usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: url,
            data: { "idUsuario": idUsuario, "accion": "ELIMINAR" },
            type: 'POST',
            dataType: 'json'
        }).done(function(response) {
            console.log("Eliminado");
            if (response == "OK") {
                swalWithBootstrapButtons.fire('','Registro eliminado','success')
            } else {
                swalWithBootstrapButtons.fire('', response ,'error')
            }
            Consultar();
        }).fail(function(response) {
            console.log(response);
        });
        } else if (
          result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire('','Operación Cancelada','info')
        }
      })
}

function Validar() {
    idPersona = document.getElementById('idPersona').value;
    nombre = document.getElementById('nombre ').value
    clave = document.getElementById('clave').value 
    rol = document.getElementById('rol').value
    if (idPersona == "" || nombre == "" || clave == "" || rol == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "idPersona": document.getElementById('idPersona').value,
        "nombre": document.getElementById('nombre').value,
        "clave": document.getElementById('clave').value,
        "rol": document.getElementById('rol').value,
        "accion": accion,
        "idUsuario": document.getElementById("idUsuario").value
    };
}

function Limpiar() {
    document.getElementById('idPersona').value = "";
    document.getElementById('nombre').value = "";
    document.getElementById('clave').value = "";
    document.getElementById('rol').value = "";
    BloquearBotones(true);
}

function Cancelar(){
    BloquearBotones(false);
    Limpiar();
}

function BloquearBotones(guardar) {
    if (guardar) {
        document.getElementById('guardar').disabled = false;
        document.getElementById('modificar').disabled = true;
        document.getElementById('cancelar').disabled = true;
    } else {
        document.getElementById('guardar').disabled = true;
        document.getElementById('modificar').disabled = false;
        document.getElementById('cancelar').disabled = false;
    }
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}

function mostrarTodo(){
    Consultar();
    document.getElementById('idUsuario').value = "";
}
