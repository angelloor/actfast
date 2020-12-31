var url = "../controlador/";

$(document).ready(function() {
    cargarFechaActual();
})

function cargarFechaActual(){
    var f = new Date();
    document.getElementById('fechaInicio').value = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
    document.getElementById('fechaFinal').value = f.getFullYear() + "-" + (f.getMonth() +1) + "-" + f.getDate()
}