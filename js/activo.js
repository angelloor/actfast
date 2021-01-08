var url = "../controlador/activo.controlador.php";

$(document).ready(function() {
    Consultar();
    EscucharConsulta();
    BloquearBotones(true);
    listarCategoria();
    listarMarca();
    listarEstado();
    listarColor();
    listarBodega();
    listarCustodio();
    cargarFechaActual();
})

function soloNumeros(){
    $('#codigo').keypress(function (event) {
      if (event.which < 48 || event.which > 57  || event.which == 9) {
        return false;
      }
    });
}

function soloNumerosPunto(){
    $('#valorCompra').keypress(function (event) {
      if (event.which < 46 || event.which > 57  || event.which == 9) {
        return false;
      }
    });
}

function cargarFechaActual(){
    var f = new Date();
    if((f.getMonth() +1) <=9){
        mesFinal = "0"+(f.getMonth() +1);
    }
    if((f.getDate()) <=9){
        diaFinal = "0"+(f.getDate());
    }
    document.getElementById('fechaIngreso').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
}

function listarCategoria(){
    $.ajax({
        data: { "accion": "LISTARCATEGORIA" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "";
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
        var html = "";
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
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_ESTADO + "</option>";
        });
        document.getElementById("estado").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function listarColor(){
    $.ajax({
        data: { "accion": "LISTARCOLOR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_COLOR + "</option>";
        });
        document.getElementById("color").innerHTML = html;
    }).fail(function(response){
        console.log(response);
    });
}

function listarBodega(){
    $.ajax({
        data: { "accion": "LISTARBODEGA" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response){
        var html = "";
        $.each(response, function(index, data) {
            html += "<option>" + data.NOMBRE_BODEGA + "</option>";
        });
        document.getElementById("bodega").innerHTML = html;
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
    $.ajax({
        data: { "accion": "CONSULTAR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        var html = "";
        $.each(response, function(index, data) {
            html += "<tr>";
            html += "<td>" + data.codigo + "</td>";
            html += "<td>" + data.nombre_activo + "</td>";
            html += "<td>" + data.nombre_categoria + "</td>";
            html += "<td>" + data.caracteristica + "</td>";
            html += "<td>" + data.nombre_marca + "</td>";
            html += "<td>" + data.modelo + "</td>";
            html += "<td>" + data.serie + "</td>";
            html += "<td>" + data.nombre_estado + "</td>";
            html += "<td>" + data.comprobacion_inventario + "</td>";
            html += "<td style='text-align: center;'>";
            html += "<button class='btn btn-success' onclick='ConsultarPorId(" + data.id_activo + ");'><span class='fa fa-edit'></span></button>"
            html += "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" + data.id_activo + ");'><span class='fa fa-trash'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function EscucharConsulta(){
    $('#idActivo').keyup(function() {
        if($('#idActivo').val()) {
          $.ajax({
            data: retornarDatosConsulta("CONSULTAR_ID_ROW"),
            url: url,
            type: 'POST',
            dataType: 'json'
            }).done(function(response) {
                console.log(response);
                var html = "";
                $.each(response, function(index, data) {
                    console.log(data);
                    html += "<tr>";
                    html += "<td>" + data.codigo + "</td>";
                    html += "<td>" + data.nombre_activo + "</td>";
                    html += "<td>" + data.nombre_categoria + "</td>";
                    html += "<td>" + data.caracteristica + "</td>";
                    html += "<td>" + data.nombre_marca + "</td>";
                    html += "<td>" + data.modelo + "</td>";
                    html += "<td>" + data.serie + "</td>";
                    html += "<td>" + data.nombre_estado + "</td>";
                    html += "<td>" + data.comprobacion_inventario + "</td>";
                    html += "<td style='text-align: center;'>";
                    html += "<button class='btn btn-success' onclick='ConsultarPorId(" + data.id_activo + ");'><span class='fa fa-edit'></span></button>"
                    html += "<button style='margin-top: 3px;' class='btn btn-danger' onclick='Eliminar(" + data.id_activo + ");'><span class='fa fa-trash'></span></button>"
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

function ConsultarPorId(idActivo) {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
              cancelButton: 'btn btn-primary mr-2 ml-2',
              confirmButton: 'btn btn-success mr-2 ml-2'
            },
            buttonsStyling: false
          })
          swalWithBootstrapButtons.fire({
            text: '¿Estas seguro de modificar el activo?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: url,
                    data: { "idActivo": idActivo, "accion": "CONSULTAR_ID" },
                    type: 'POST',
                    dataType: 'json'
                }).done(function(response) {
                    console.log(response);
                    document.getElementById('categoria').value = response.nombre_categoria;
                    document.getElementById('marca').value = response.nombre_marca;
                    document.getElementById('estado').value = response.nombre_estado;
                    document.getElementById('color').value = response.nombre_color;
                    document.getElementById('caracteristica').value = response.caracteristica;
                    document.getElementById('bodega').value = response.nombre_bodega;
                    document.getElementById('custodio').value = response.nombre_persona;
                    document.getElementById('codigo').value = response.codigo;
                    document.getElementById('nombre').value = response.nombre_activo;
                    document.getElementById('modelo').value = response.modelo;
                    document.getElementById('serie').value = response.serie;
                    document.getElementById('origenIngreso').value = response.origen_ingreso;
                    document.getElementById('fechaIngreso').value = response.fecha_ingreso;
                    document.getElementById('valorCompra').value = response.valor_compra;
                    document.getElementById('comentario').value = response.comentario;
                    document.getElementById('comprobacionInventario').value = response.comprobacion_inventario;
                    document.getElementById('idActivo').value = response.id_activo;
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
        console.log(response);
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
        console.log(response);
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

function Eliminar(idActivo) {
    var f = new Date();
    if((f.getMonth() +1) <=9){
        mesFinal = "0"+(f.getMonth() +1);
    }
    if((f.getDate()) <=9){
        diaFinal = "0"+(f.getDate());
    }
    var fechaEliminar = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de eliminar el activo?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
        $.ajax({
            url: url,
            data: { "idActivo": idActivo, "accion": "ELIMINAR", "fechaEliminar": fechaEliminar },
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
    categoria = document.getElementById('categoria').value
    marca = document.getElementById('marca').value
    estado = document.getElementById('estado').value
    color = document.getElementById('color').value
    caracteristica = document.getElementById('caracteristica').value
    bodega = document.getElementById('bodega').value
    custodio = document.getElementById('custodio').value
    codigo = document.getElementById('codigo').value
    nombre = document.getElementById('nombre').value
    modelo = document.getElementById('modelo').value
    serie = document.getElementById('serie').value
    origenIngreso = document.getElementById('origenIngreso').value
    fechaIngreso = document.getElementById('fechaIngreso').value
    valorCompra = document.getElementById('valorCompra').value
    comentario = document.getElementById('comentario').value
    comprobacionInventario = document.getElementById('comprobacionInventario').value
   
    if (categoria == "" || marca == "" || estado == "" || color == "" || caracteristica == "" || bodega == "" || custodio == "" || codigo == "" || nombre == "" || modelo == "" || serie == "" || origenIngreso == "" || fechaIngreso == "" || valorCompra == "" || comentario == "" || comprobacionInventario == "") {
        return false;
    }
    return true;
}

function retornarDatosConsulta(accion){
    return{
        "campoBuscar": document.getElementById('campoBuscar').value,
        "accion": accion,
        "idActivo": document.getElementById('idActivo').value
    }
}
function retornarDatos(accion) {
    return {
        "categoria": document.getElementById('categoria').value,
        "marca": document.getElementById('marca').value,
        "estado": document.getElementById('estado').value,
        "color": document.getElementById('color').value,
        "caracteristica": document.getElementById('caracteristica').value,
        "bodega": document.getElementById('bodega').value,
        "custodio": document.getElementById('custodio').value,
        "codigo": document.getElementById('codigo').value,
        "nombre": document.getElementById('nombre').value,
        "modelo": document.getElementById('modelo').value,
        "serie": document.getElementById('serie').value,
        "origenIngreso": document.getElementById('origenIngreso').value,
        "fechaIngreso": document.getElementById('fechaIngreso').value,
        "valorCompra": document.getElementById('valorCompra').value,
        "comentario": document.getElementById('comentario').value,
        "comprobacionInventario": document.getElementById('comprobacionInventario').value,
        "accion": accion,
        "idActivo": document.getElementById("idActivo").value
    };
}

function Limpiar() {
    document.getElementById('idActivo').value = "";
    document.getElementById('caracteristica').value = "";
    document.getElementById('codigo').value = "";
    document.getElementById('nombre').value = "";
    document.getElementById('modelo').value = "";
    document.getElementById('serie').value = "";
    document.getElementById('origenIngreso').value = "";
    document.getElementById('fechaIngreso').value = "";
    document.getElementById('valorCompra').value = "";
    document.getElementById('comentario').value = "";
    document.getElementById('comprobacionInventario').value = "";
    listarCategoria();
    listarMarca();
    listarEstado();
    listarColor();
    listarBodega();
    listarCustodio();
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
    document.getElementById('idActivo').value = "";
}