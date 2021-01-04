var url = "../controlador/";

$(document).ready(function() {
    cargarFechaActual();
})

function cargarFechaActual(){
    var f = new Date();
    if((f.getMonth() +1) <=9){
        mesFinal = "0"+(f.getMonth() +1);
    }
    if((f.getDate()) <=9){
        diaFinal = "0"+(f.getMonth() +1);
    }
    document.getElementById('fechaInicio').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
    document.getElementById('fechaFinal').value = f.getFullYear() + "-" + mesFinal + "-" + diaFinal;
}