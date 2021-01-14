var url = "../controlador/color.controlador.php";
var registrosTotales = false;
$(document).ready(function() {
    Consultar();
    EscucharConsulta();
    BloquearBotones(true);
})

function mostrarAlertaDatos(){
    var alerta = document.getElementById('alerta');
    alerta.style.display = "block";
}

function ocultarAlerta(){
    var alerta = document.getElementById('alerta');
    alerta.style.display = "none";
}

function soloLetras(){
    $('#nombre').keypress(function (event) {
      if (!((event.which >= 65 && event.which <= 90) || (event.which >= 97 && event.which <= 122) || (event.which == 32))) {
        return false;
      }
    });
}

function Consultar() {
    registrosTotales = false;
    $.ajax({
        data: { "accion": "CONSULTAR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response.length >= 1) {
            registrosTotales = true;
            ocultarAlerta();
        }else{
            mostrarAlertaDatos();
        }
        var html = "";
        $.each(response, function(index, data) {
            html += "<tr>";
            html += "<td>" + data.nombre_color + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_color + ");'><span class='fa fa-edit'></span></button>"
            html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_color + ");'><span class='fa fa-trash'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function EscucharConsulta(){
    registrosTotales = false;
    $('#idColor').keyup(function() {
        if($('#idColor').val()) {
          let idBuscar = $('#idColor').val();
          $.ajax({
            data: { "idBuscar": idBuscar, "accion": "CONSULTAR_ID_ROW" },
            url: url,
            type: 'POST',
            dataType: 'json'
            }).done(function(response) {
                if (response.length >= 1) {
                    registrosTotales = true;
                    ocultarAlerta();
                }else{
                    mostrarAlertaDatos();
                }
                var html = "";
                $.each(response, function(index, data) {
                    html += "<tr>";
                    html += "<td>" + data.nombre_color + "</td>";
                    html += "<td style='text-align: right;'>";
                    html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_color + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_color + ");'><span class='fa fa-trash'></span></button>"
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

function ConsultarPorId(idColor) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-primary mr-2 ml-2',
              confirmButton: 'btn btn-success mr-2 ml-2'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            text: '¿Estas seguro de modificar el Color?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    data: { "idColor": idColor, "accion": "CONSULTAR_ID" },
                    type: 'POST',
                    dataType: 'json'
                }).done(function(response) {
                    document.getElementById('nombre').value = response.nombre_color;
                    document.getElementById('idColor').value = response.id_color;
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

function Eliminar(idColor) {
    var registros = 0;

    $.ajax({
        url: url,
        data: { "idColor": idColor, "accion": "CONSULTARREGISTROS" },
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        registros = response.registros;
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-primary mr-2 ml-2',
              confirmButton: 'btn btn-success mr-2 ml-2'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            title:'¿Estas seguro de eliminar el color? Contiene '+registros+' activos registrados',
            text: 'Nota: no es recomendable, se perderán todos los registros que se encuentren asociados a este color',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
            $.ajax({
                url: url,
                data: { "idColor": idColor, "accion": "ELIMINAR" },
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
    }).fail(function(response) {
        console.log(response);
    });

    
}

function Validar() {
    nombreColor = document.getElementById('nombre').value
    if (nombreColor == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "nombreColor": (document.getElementById('nombre').value).toUpperCase(),
        "accion": accion,
        "idColor": document.getElementById("idColor").value
    };
}

function Limpiar() {
    document.getElementById('idColor').value = "";
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
    document.getElementById('idColor').value = "";
}