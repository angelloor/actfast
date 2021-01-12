var url = "../controlador/main.controlador.php";
var urlGet = "";

$(document).ready(function() {
  cargarCategoria();
  listarActivo();
  document.getElementById('SelectCategoriaDos').addEventListener('change',listarFuncionarioPorCategoria,false );
  document.getElementById('saltoLineaDos').addEventListener('keypress', soloNumeros, false);
  document.getElementById('saltoLineaTres').addEventListener('keypress', soloNumeros, false);
  document.getElementById('codigoActivo').addEventListener('keypress', soloNumeros, false);
})

function soloNumeros(e){
  var key = window.event ? e.which : e.keyCode;
  if (key < 48 || key > 57) {
    e.preventDefault();
  }
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
          html += "<option>" + data.nombre_categoria + "</option>";
      });
      document.getElementById("SelectCategoria").innerHTML = html;
      document.getElementById("SelectCategoriaDos").innerHTML = html;
  }).fail(function(response){
      console.log(response);
  });
}

function listarFuncionarioPorCategoria(){
  categoria = document.getElementById('SelectCategoriaDos').value;
  $.ajax({
      data: { "accion": "LISTARFUNCIONARIOPORCATEGORIA", "categoria": categoria },
      url: url,
      type: 'POST',
      dataType: 'json'
  }).done(function(response){
      var html = "";
      $.each(response, function(index, data) {
          html += "<option>" + data.nombre_persona + "</option>";
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
  urlGet = urlGet+"categoria="+categoriaUno;
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
  document.getElementById('saltoLineaDos').value = "";
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
    document.getElementById('codigoActivo').value = "";
    document.getElementById('saltoLineaTres').value = "";
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


