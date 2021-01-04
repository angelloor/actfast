var url = "../controlador/marca.controlador.php";

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
            html += "<td>" + data.NOMBRE_MARCA + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.ID_MARCA + ");'><span class='fa fa-edit'></span></button>"
            html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.ID_MARCA + ");'><span class='fa fa-trash'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function EscucharConsulta(){
    $('#idMarca').keyup(function() {
        if($('#idMarca').val()) {
          let idBuscar = $('#idMarca').val();
          $.ajax({
            data: { "idBuscar": idBuscar, "accion": "CONSULTAR_ID_ROW" },
            url: url,
            type: 'POST',
            dataType: 'json'
            }).done(function(response) {
                var html = "";
                $.each(response, function(index, data) {
                    html += "<tr>";
                    html += "<td>" + data.NOMBRE_MARCA + "</td>";
                    html += "<td style='text-align: right;'>";
                    html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.ID_MARCA + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.ID_MARCA + ");'><span class='fa fa-trash'></span></button>"
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

function ConsultarPorId(idMarca) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-primary mr-2 ml-2',
              confirmButton: 'btn btn-success mr-2 ml-2'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            text: '¿Estas seguro de modificar la Marca?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    data: { "idMarca": idMarca, "accion": "CONSULTAR_ID" },
                    type: 'POST',
                    dataType: 'json'
                }).done(function(response) {
                    document.getElementById('nombre').value = response.NOMBRE_MARCA;
                    document.getElementById('idMarca').value = response.ID_MARCA;
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

function Eliminar(idMarca) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de eliminar la Marca?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: url,
            data: { "idMarca": idMarca, "accion": "ELIMINAR" },
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
      Limpiar();
}

function Validar() {
    nombreMarca = document.getElementById('nombre').value
    if (nombreMarca == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "nombreMarca": (document.getElementById('nombre').value).toUpperCase(),
        "accion": accion,
        "idMarca": document.getElementById("idMarca").value
    };
}

function Limpiar() {
    document.getElementById('idMarca').value = "";
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
    document.getElementById('idMarca').value = "";
}