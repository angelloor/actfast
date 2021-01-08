var url = "../controlador/main.controlador.php";
var urlGet = "";
$(document).ready(function() {
  cargarCategoria();
  listarFuncionario();
  listarActivo();
  
})

function soloNumeros(){
  $('#codigoActivo').keydown(function (event) {
    if (event.which < 48 || event.which > 57 ) {
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
  urlGet = urlGet+"categoria="+categoriaUno;
  window.open('../modelo/actaGlobal.php?'+urlGet, '_blank');
  close();
  clear();
}

function GenerarPorFuncionario(){
  urlGet = "";
  funcionario = document.getElementById('SelectFuncionario').value;
  categoriaDos = document.getElementById('SelectCategoriaDos').value;
  urlGet = urlGet+"categoria="+categoriaDos+"&funcionario="+funcionario;
  window.open('../modelo/actaPorFuncionario.php?'+urlGet, '_blank');
  close();
  clear();
}

function GenerarPorActivo(){
  urlGet = "";
  activo = document.getElementById('codigoActivo').value;
  if (activo == "") {
    MostrarAlerta("","Seleccione un activo","info");
    return;
  }else{
    urlGet = urlGet+"activo="+activo;
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


