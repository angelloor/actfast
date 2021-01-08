var url = "../controlador/firma.controlador.php";
var idFirmaActualizar = 0;

$(document).ready(function() {
    BloquearBotones(true);
    listarFuncionario();
    Consultar();
})

function Cancelar(){
    document.getElementById('denominacion').value = "";
    listarFuncionario();
    BloquearBotones(true);
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
            html += "<option>" + data.NOMBRE_PERSONA + "</option>";
        });
        document.getElementById("nombrePersona").innerHTML = html;
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
            html += "<td>" + data.nombre_persona + "</td>";
            html += "<td>" + data.denominacion + "</td>";
            html += "<td style='text-align: right;'>";
            html += "<button class='btn btn-success mr-1' onclick='ConsultarPorId(" + data.id_firma + ");'><span class='fa fa-edit'></span></button>"
            html += "</td>";
            html += "</tr>";
        });
        document.getElementById("datos").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
}

function ConsultarPorId(idFirma) {
    idFirmaActualizar = idFirma;
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
          cancelButton: 'btn btn-primary mr-2 ml-2',
          confirmButton: 'btn btn-success mr-2 ml-2'
        },
        buttonsStyling: false
      })
      swalWithBootstrapButtons.fire({
        text: '¿Estas seguro de modificar el gestionActa?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Si',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
      }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: url,
                data: { "idFirma": idFirma, "accion": "CONSULTAR_ID" },
                type: 'POST',
                dataType: 'json'
            }).done(function(response) {
                BloquearBotones(false);
                document.getElementById('nombrePersona').value = response.nombre_persona;
                document.getElementById('denominacion').value = response.denominacion;
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

function Modificar() {
    nombrePersona = document.getElementById('nombrePersona').value,
    denominacion = (document.getElementById('denominacion').value).toUpperCase(),
    $.ajax({
        url: url,
        data: { "idFirma": idFirmaActualizar, "nombrePersona": nombrePersona, "denominacion": denominacion, "accion": "MODIFICAR" },
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        if (response == "OK") {
            MostrarAlerta("Éxito!", "Datos actualizados con éxito", "success");
            Consultar();
            Cancelar();
        } else {
            MostrarAlerta("Error!", response, "error");
        }
    }).fail(function(response) {
        console.log(response);
    });
}

function BloquearBotones(guardar) {
    if (guardar) {
        document.getElementById('modificar').disabled = true;
        document.getElementById('cancelar').disabled = true;
        document.getElementById('nombrePersona').disabled = true;
        document.getElementById('denominacion').disabled = true;

    } else {
        document.getElementById('modificar').disabled = false;
        document.getElementById('cancelar').disabled = false;
        document.getElementById('nombrePersona').disabled = false;
        document.getElementById('denominacion').disabled = false;
    }
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
    Swal.fire(
        titulo,
        descripcion,
        tipoAlerta
    );
}