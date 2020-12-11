var url = "../controlador/rol_usuario.controlador.php";

$(document).ready(function() {
    Consultar();
    EscucharConsulta();
    BloquearBotones(true);
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
            html += "<td>" + data.ID_ROL_USUARIO + "</td>";
            html += "<td>" + data.NOMBRE_ROL_USUARIO + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.ID_ROL_USUARIO + ");'><span class='fa fa-edit'></span></button>"
            html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.ID_ROL_USUARIO + ");'><span class='fa fa-trash'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function EscucharConsulta(){
    $('#idRolUsuario').keyup(function() {
        if($('#idRolUsuario').val()) {
          let idBuscar = $('#idRolUsuario').val();
          $.ajax({
            data: { "idBuscar": idBuscar, "accion": "CONSULTAR_ID_ROW" },
            url: url,
            type: 'POST',
            dataType: 'json'
            }).done(function(response) {
                var html = "";
                $.each(response, function(index, data) {
                    html += "<tr>";
                    html += "<td>" + data.ID_ROL_USUARIO + "</td>";
                    html += "<td>" + data.NOMBRE_ROL_USUARIO + "</td>";
                    html += "<td style='text-align: right;'>";
                    html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.ID_ROL_USUARIO + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.ID_ROL_USUARIO + ");'><span class='fa fa-trash'></span></button>"
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

function ConsultarPorId(idRolUsuario) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-primary mr-2 ml-2',
              confirmButton: 'btn btn-success mr-2 ml-2'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            text: '¿Estas seguro de modificar el rol de usuario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    data: { "idRolUsuario": idRolUsuario, "accion": "CONSULTAR_ID" },
                    type: 'POST',
                    dataType: 'json'
                }).done(function(response) {
                    document.getElementById('nombre').value = response.NOMBRE_ROL_USUARIO;
                    document.getElementById('idRolUsuario').value = response.ID_ROL_USUARIO;
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

function Eliminar(idRolUsuario) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de eliminar el rol de usuario?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: url,
            data: { "idRolUsuario": idRolUsuario, "accion": "ELIMINAR" },
            type: 'POST',
            dataType: 'json'
        }).done(function(response) {
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
    nombreRolUsuario = document.getElementById('nombre').value
    if (nombreRolUsuario == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "nombreRolUsuario": document.getElementById('nombre').value,
        "accion": accion,
        "idRolUsuario": document.getElementById("idRolUsuario").value
    };
}

function Limpiar() {
    document.getElementById('nombre').value = "";
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
    document.getElementById('idRolUsuario').value = "";
}