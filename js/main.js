var url = "../controlador/main.controlador.php";
var urlGet = "";
$(document).ready(function() {
  cargarCategoria();
  listarFuncionario();
  listarActivo();
  
})

function soloNumeros(){
  $('input').keypress(function (event) {
    if (event.which < 48 || event.which > 57  || event.which == 9) {
      return false;
    }
  });
}


function cargarCategoria(){
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
      document.getElementById("SelectCategoria").innerHTML = html;
      document.getElementById("SelectCategoriaDos").innerHTML = html;
  }).fail(function(response){
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
      document.getElementById("SelectFuncionario").innerHTML = html;
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

function GenerarTodasActas(){
  urlGet = "";
  categoriaUno = document.getElementById('SelectCategoria').value;
  saltoLinea = document.getElementById('saltoLineaUno').value;
  urlGet = urlGet+"categoria="+categoriaUno+"&saltoLinea="+saltoLinea;
  window.open('../modelo/actaGlobal.php?'+urlGet, '_blank');
  close();
  clear();
}

function GenerarPorFuncionario(){
  urlGet = "";
  funcionario = document.getElementById('SelectFuncionario').value;
  categoriaDos = document.getElementById('SelectCategoriaDos').value;
  saltoLinea = document.getElementById('saltoLineaDos').value;
  urlGet = urlGet+"categoria="+categoriaDos+"&funcionario="+funcionario+"&saltoLinea="+saltoLinea;
  window.open('../modelo/actaPorFuncionario.php?'+urlGet, '_blank');
  close();
  clear();
}

function GenerarPorActivo(){
  urlGet = "";
  activo = document.getElementById('codigoActivo').value;
  saltoLinea = document.getElementById('saltoLineaTres').value;
  if (activo == "") {
    MostrarAlerta("","Seleccione un activo","info");
    return;
  }else{
    urlGet = urlGet+"activo="+activo+"&saltoLinea="+saltoLinea;
    window.open('../modelo/actaPorActivo.php?'+urlGet, '_blank');
    close();
    clear();
  }
}

function MostrarAlerta(titulo, descripcion, tipoAlerta) {
  Swal.fire(
      titulo,
      descripcion,
      tipoAlerta
  );
}


