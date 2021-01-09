var url = "../controlador/actaDigital.controlador.php";

var vacio = 0;
var checkInput = 0;
var urlGet = "";

$(document).ready(function() {
    cargarSistemas();
    listarFuncionario();
    document.getElementById('periodo').addEventListener("keypress", soloNumeros, false);
})

function soloNumeros(e){
    input = document.getElementById('periodo');
    var key = window.event ? e.which : e.keyCode;
    if (key < 48 || key > 57 || (input.value.length === 4)) {
      e.preventDefault();
    }
  }

function Generar(){
    vacio = 0;
    checkInput = 0;
    urlGet = "";
    $.ajax({
        data: { "accion": "CARGARSISTEMAS" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        $.each(response, function(index, data) {
            var checkbox = document.getElementById(data.nombre_sistema);
            var checked = checkbox.checked;
            if (checked) {
                checkInput = checkInput + 1;
                var usuario = document.getElementById(("usuario"+data.nombre_sistema)).value;
                var clave = document.getElementById(("clave"+data.nombre_sistema)).value;
                if (usuario == "" || clave == "") {
                    vacio = vacio + 1;
                }
                urlGet = urlGet + "sistema"+(index+1)+"="+data.nombre_sistema+"&url"+(index+1)+"="+data.direccion_sistema+"&usuario"+(index+1)+"="+usuario+"&clave"+(index+1)+"="+clave+"&";
            }
        });
        if (checkInput == 0) {
            MostrarAlerta("","No se ha seleccionado ningun sistema","info");
        }else{
            if (vacio >= 1) {
                MostrarAlerta("","Complete el usuario o contraseña","info");
            }else{
                nombrePersona = document.getElementById('idPersona').value;
                periodo = document.getElementById('periodo').value;
                if (periodo == "") {
                    MostrarAlerta("","Ingrese el año del proceso","info");
                    return;
                }
                urlGet = urlGet+"totalSistemas="+checkInput+"&funcionario="+nombrePersona+"&periodo="+periodo;
                console.log(urlGet);
                window.open('../modelo/actaDigital.php?'+urlGet, '_blank');
            }
        }

    }).fail(function(response) {
        console.log(response);
    });
}

function validarCheckbox(idCheck){
    var checkbox = document.getElementById(idCheck.id);
    if(checkbox){
        checkbox.addEventListener("change", validar, false);
    }
    function validar(){
        var checked = checkbox.checked;
        if(checked){
            document.getElementById(("usuario"+idCheck.id)).disabled = false;
            document.getElementById(("clave"+idCheck.id)).disabled = false;
            document.getElementById(("usuario"+idCheck.id)).focus();
        }else{
            document.getElementById(("usuario"+idCheck.id)).value = "";
            document.getElementById(("clave"+idCheck.id)).value = "";
            document.getElementById(("usuario"+idCheck.id)).disabled = true;
            document.getElementById(("clave"+idCheck.id)).disabled = true;
        }
    }
}


function cargarSistemas(){
    $.ajax({
        data: { "accion": "CARGARSISTEMAS" },
        url: url,
        type: 'POST',
        dataType: 'json'
    }).done(function(response) {
        var html = "";
        $.each(response, function(index, data) {
            html += '<div class="row">';
            html += '<div class="col-md-2 pl-5 mt-4">';
            html += '<div class="form-check">';
            html += '<input class="form-check-input" type="checkbox" value="" id="'+data.nombre_sistema+'" onclick="validarCheckbox(this);" >';
            html += '<label class="form-check-label" for="flexCheckDefault">';
            html += data.nombre_sistema;
            html += '</label>';
            html += '</div>';
            html += '</div>';
            html += '<div class="col-md-4">';
            html += '<label for="nombres">Nombre de usuario</label>';
            html += '<input id="usuario'+data.nombre_sistema+'" type="text" class="form-control" placeholder="Ingrese el nombre de usuario" disabled="true">';
            html += '</div>';
            html += '<div class="col-md-4">';
            html += '<label for="nombres">Contraseña</label>';
            html += '<input id="clave'+data.nombre_sistema+'" type="text" class="form-control" placeholder="1600###### o Numero Cédula" disabled="true">';
            html += '</div>';
            html += '</div>';
        });
        document.getElementById("sistemas").innerHTML = html;
    }).fail(function(response) {
        console.log(response);
    });
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
        document.getElementById("idPersona").innerHTML = html;
    }).fail(function(response){
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
