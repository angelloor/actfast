var url = "../controlador/historico.controlador.php";
var urlGet = "";
var registrosTotales = false;

$(document).ready(function() {
    cargarFechaActual();
    consultar();
})

function pdf(){
    if (comprobarFechas() == 1) {
        MostrarAlerta("","Ingrese el rango de las fechas","info");
    }else{
        if (comprobarFechas() == 2) {
            MostrarAlerta("","Ingrese la fecha inicial","info");
        }else{
            if (comprobarFechas() == 3) {
                MostrarAlerta("","Ingrese la fecha final","info");
            }else{
                urlGet = "";
                fechaInicio = document.getElementById('fechaInicio').value;
                fechaFinal = document.getElementById('fechaFinal').value;
                accion = "pdf";
                if (registrosTotales == false) {
                    MostrarAlerta("","No se encuentran registros de "+fechaInicio+" a "+fechaFinal,"info");
                    return;
                }else{
                    urlGet = urlGet+"fechaInicio="+fechaInicio+"&fechaFinal="+fechaFinal+"&accion="+accion;
                    window.open('../modelo/reporteHistorico.php?'+urlGet, '_blank');
                }
            }
        }
    }
}

function excel(){
    if (comprobarFechas() == 1) {
        MostrarAlerta("","Ingrese el rango de las fechas","info");
    }else{
        if (comprobarFechas() == 2) {
            MostrarAlerta("","Ingrese la fecha inicial","info");
        }else{
            if (comprobarFechas() == 3) {
                MostrarAlerta("","Ingrese la fecha final","info");
            }else{
                urlGet = "";
                fechaInicio = document.getElementById('fechaInicio').value;
                fechaFinal = document.getElementById('fechaFinal').value;
                accion = "excel";
                if (registrosTotales == false) {
                    MostrarAlerta("","No se encuentran registros de "+fechaInicio+" a "+fechaFinal,"info");
                    return;
                }else{
                    urlGet = urlGet+"fechaInicio="+fechaInicio+"&fechaFinal="+fechaFinal+"&accion="+accion;
                    window.open('../modelo/reporteHistorico.php?'+urlGet, '_blank');
                }
            }
        }
    }
}

function comprobarFechas(){
    fechaInicio = document.getElementById('fechaInicio').value;
    fechaFinal = document.getElementById('fechaFinal').value;
    if (fechaInicio == "" && fechaFinal == "") {
        return 1;
    }else{
        if (fechaInicio == "") {
            return 2;
        }else{
            if (fechaFinal == "") {
                return 3;
            }
        }
    }
    return 0;
}

function ConsultarPorFecha(){
    registrosTotales = false;
    if (comprobarFechas() == 1) {
        MostrarAlerta("","Ingrese el rango de las fechas","info");
    }else{
        if (comprobarFechas() == 2) {
            MostrarAlerta("","Ingrese la fecha inicial","info");
        }else{
            if (comprobarFechas() == 3) {
                MostrarAlerta("","Ingrese la fecha final","info");
            }else{
                fechaInicio = document.getElementById('fechaInicio').value;
                fechaFinal = document.getElementById('fechaFinal').value;
                $.ajax({
                    data: { "accion": "CONSULTARPORFECHA", "fechaInicio": fechaInicio,"fechaFinal":  fechaFinal},
                    url: url,
                    type: 'POST',
                    dataType: 'json'
                }).done(function(response) {
                    if (response.length >= 1) {
                        registrosTotales = true;
                    }
                    var html = "";
                    $.each(response, function(index, data) {
                        html += "<tr>";
                        html += "<td>" + data.codigo + "</td>";
                        html += "<td>" + data.nombre_activo + "</td>";
                        html += "<td>" + data.nombre_marca + "</td>";
                        html += "<td>" + data.modelo + "</td>";
                        html += "<td>" + data.serie + "</td>";
                        html += "<td>" + data.fecha_historico + "</td>";
                        html += "<td style='text-align: center;'>";
                        html += "<button class='btn btn-success' onclick='ConsultarPorId(" + data.id_activo + ");'><span class='fa fa-undo-alt'></span></button>"
                        html += "</td>";
                        html += "</tr>";
                    });
                    document.getElementById("datos").innerHTML = html;
                }).fail(function(response) {
                    console.log(response);
                });
            }
        }
    }
}

function cargarFechaActual(){
    var f = new Date();
    if((f.getMonth() +1) <=9){
        mesFinal = "0"+(f.getMonth() +1);
    }
    if((f.getDate()) <=9){
        diaFinal = "0"+(f.getDate());
    }
    document.getElementById('fechaInicio').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
    document.getElementById('fechaFinal').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
}

function consultar(){
    registrosTotales = false;
    $.ajax({
        data: { "accion": "CONSULTAR" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response.length >= 1) {
            registrosTotales = true;
        }
        var html = "";
        $.each(response, function(index, data) {
            html += "<tr>";
            html += "<td>" + data.codigo + "</td>";
            html += "<td>" + data.nombre_activo + "</td>";
            html += "<td>" + data.nombre_marca + "</td>";
            html += "<td>" + data.modelo + "</td>";
            html += "<td>" + data.serie + "</td>";
            html += "<td>" + data.fecha_historico + "</td>";
            html += "<td style='text-align: center;'>";
            html += "<button class='btn btn-success' onclick='ConsultarPorId(" + data.id_activo + ");'><span class='fa fa-undo-alt'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function ConsultarPorId(idActivo) {
    var f = new Date();
    var fechaHistorico = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
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
                data: { "idActivo": idActivo, "accion": "CONSULTAR_ID", "fechaHistorico": fechaHistorico },
                type: 'POST',
                dataType: 'json'
            }).done(function(response) {
                if (response == "OK") {
                    MostrarAlerta("","El activo se ha devuelto al inventario","info");
                    consultar();
                }else{
                    MostrarAlerta("",response,"info");
                }
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


function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}