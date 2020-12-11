var url = "../controlador/main.controlador.php";

function actaUsuario(){
  Swal.fire({
    title: '',
    text: 'Seleccione la categoria',
    input: 'select',
    inputOptions: 
      $.ajax({
        url: url,
        data: { "accion": "CARGARCATEGORIA" },
        type: 'POST',
        dataType: 'json'
      }).done(function(response) {
          var array = {}
          $.each(response, function(index, data) {
            array = {
              "cat": data.NOMBRE_CATEGORIA
            }
            console.log(data.NOMBRE_CATEGORIA);
          });
          console.log(array);
          return array;
      }).fail(function(response) {
          console.log(response);
      })
    ,
    showCancelButton: true,
    inputValidator: function (value) {
      return new Promise(function (resolve, reject) {
        if (value !== '') {
          resolve();
        } else {
          resolve('You need to select a Tier');
        }
      });
    }
  }).then(function (result) {
    if (result.value) {
      Swal.fire({
        icon: 'success',
        html: 'You selected: ' + result.value
      });
    }
  });

  function cargarCategoria(){
    
   
  }

}