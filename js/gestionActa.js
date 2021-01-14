var url = "../controlador/gestionActa.controlador.php";
var registrosTotales = false;
$(document).ready(function() {
    BloquearBotones(true);
    Consultar();
    EscucharConsulta();
    listarFuncionario();
    listarActivo();
    listarCustodio();
    cargarFechaActual();
    document.getElementById('codigoActivo').addEventListener('keypress', soloNumeros, false);
})

function mostrarAlertaDatos(){
    var alerta = document.getElementById('alerta');
    alerta.style.display = "block";
}

function ocultarAlerta(){
    var alerta = document.getElementById('alerta');
    alerta.style.display = "none";
}

function soloNumeros(e){
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57) {
      e.preventDefault();
    }
}

function cargarFechaActual(){
    var f = new Date();
    if((f.getMonth() +1) <=9){
        mesFinal = "0"+(f.getMonth() +1);
    }else{
        mesFinal = f.getMonth();
    }
    if((f.getDate()) <=9){
        diaFinal = "0"+(f.getDate());
    }else{
        diaFinal = f.getDate();
    }
    document.getElementById('fecha').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
}

function listarFuncionario(){
    $.ajax({
        data: { "accion": "LISTARFUNCIONARIO" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.nombre_persona + "</option>";
        });
        document.getElementById("idPersona").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function listarActivo(){
    $.ajax({
        data: { "accion": "LISTARACTIVO" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.activo + "</option>";
        });
        document.getElementById("activo").innerHTML = html;
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
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.nombre_persona + "</option>";
        });
        document.getElementById("custodio").innerHTML = html;
    }).fail(function(response){
        console.log(response);
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
            html += "<td>" + data.funcionario + "</td>";
            html += "<td>" + data.codigo + "</td>";
            html += "<td>" + data.custodio + "</td>";
            html += "<td>" + data.fecha + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_entrega_recepcion + ");'><span class='fa fa-edit'></span></button>"
            html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_entrega_recepcion + ");'><span class='fa fa-trash'></span></button>"
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
    $('#idGestionActa').keyup(function() {
        if($('#idGestionActa').val()) {
          $.ajax({
            data: retornarDatosConsulta("CONSULTAR_ID_ROW"),
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
                    html += "<td>" + data.funcionario + "</td>";
                    html += "<td>" + data.codigo + "</td>";
                    html += "<td>" + data.custodio + "</td>";
                    html += "<td>" + data.fecha + "</td>";
                    html += "<td style='text-align: right;'>";
                    html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_entrega_recepcion + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button class='btn btn-danger ml-1' onclick='Eliminar(" + data.id_entrega_recepcion + ");'><span class='fa fa-trash'></span></button>"
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

function ConsultarPorId(idGestionActa) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de modificar la asignación del activo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                data: { "idGestionActa": idGestionActa, "accion": "CONSULTAR_ID" },
                type: 'POST',
                dataType: 'json'
            }).done(function(response) {
                document.getElementById('idPersona').value = response.funcionario;
                document.getElementById('codigoActivo').value = response.codigo;
                document.getElementById('custodio').value = response.custodio;
                document.getElementById('fecha').value = response.fecha;
                document.getElementById('idGestionActa').value = response.id_entrega_recepcion;
                document.getElementById('codigoActivo').disabled = true;
                BloquearBotones(false);
            }).fail(function(response) {
                console.log(response);
            });
        } else if (
          result.dismiss === Swal.DismissReason.cancel
        ) {
            swalWithBootstrapButtons.fire('','Operación cancelada','info')
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

function Eliminar(idGestionActa) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de eliminar la asignación del activo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: url,
            data: { "idGestionActa": idGestionActa, "accion": "ELIMINAR" },
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
            swalWithBootstrapButtons.fire('','Operación cancelada','info')
        }
      })
      Limpiar();
}

function Validar() {
    idPersona = document.getElementById('idPersona').value;
    codigoActivo = document.getElementById('codigoActivo').value
    custodio = document.getElementById('custodio').value 
    fecha = document.getElementById('fecha').value
    if (idPersona == "" || codigoActivo == "" || custodio == "" || fecha == "") {
        return false;
    }
    return true;
}

function retornarDatos(accion) {
    return {
        "idPersona": document.getElementById('idPersona').value,
        "codigoActivo": document.getElementById('codigoActivo').value,
        "custodio": document.getElementById('custodio').value,
        "fecha": document.getElementById('fecha').value,
        "accion": accion,
        "idGestionActa": document.getElementById("idGestionActa").value
    };
}

function retornarDatosConsulta(accion){
    return{
        "campoBuscar": document.getElementById('campoBuscar').value,
        "accion": accion,
        "idGestionActa": document.getElementById('idGestionActa').value
    }
}

function Limpiar() {
    document.getElementById('idGestionActa').value = "";
    document.getElementById('codigoActivo').value = "";
    document.getElementById('codigoActivo').disabled = false;
    listarCustodio();
    listarFuncionario();
    cargarFechaActual();
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
    document.getElementById('idGestionActa').value = "";
}
