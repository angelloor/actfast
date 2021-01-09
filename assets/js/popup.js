$(document).ready(function() {
})

//  Botones
var btnCategoria = document.getElementById('btnCategoria'),
    btnFuncionario = document.getElementById('btnFuncionario'),
    btnActivo = document.getElementById('btnActivo'),
    btnReporte = document.getElementById('btnReporte'),
	btnactasDigitales = document.getElementById('btnactasDigitales'),
	btnCerrarPopup = document.getElementById('btnCerrarPopup');
	
// Formularios
var Categoria = document.getElementById('popupBodyCategoria'),
    Reporte = document.getElementById('popupBodyReporte'),
    Funcionario = document.getElementById('popupBodyFuncionario'),
    ActasDigitales = document.getElementById('popupBodyActasDigitales'),
    Activo = document.getElementById('popupBodyActivo');

// Popups
var overlay = document.getElementById('overlay'),
    popup = document.getElementById('popup');

// Eventos
btnCategoria.addEventListener('click', function(target) {
    callPopupFrame(target.target.name);
});

btnReporte.addEventListener('click', function(target) {
    callPopupFrame(target.target.name);
});

btnFuncionario.addEventListener('click', function(target) {
    callPopupFrame(target.target.name);
});

btnActivo.addEventListener('click', function(target) {
    callPopupFrame(target.target.name);
});

btnactasDigitales.addEventListener('click', function(target) {
    callPopupFrame(target.target.name);
});

btnCerrarPopup.addEventListener('click', function(e) {
    e.preventDefault();
    close();
    clear();
});

// funciones
function callPopupFrame(target) {
    overlay.classList.add('active');
    popup.classList.add('active');
    clear();
    switch (target) {
        case 'categoria':
            Categoria.removeAttribute('hidden');
            break;
        case 'funcionario':
            Funcionario.removeAttribute('hidden');
            listarFuncionarioPorCategoria();
            break;
        case 'activo':
            Activo.removeAttribute('hidden');
            break;
        case 'reporte':
            Reporte.removeAttribute('hidden');
			break;
		case 'actasDigitales':
			ActasDigitales.removeAttribute('hidden');
			break;
    }
}

function clear() {
    Categoria.setAttribute('hidden', true);
    Funcionario.setAttribute('hidden', true);
    Activo.setAttribute('hidden', true);
    Reporte.setAttribute('hidden', true);
    ActasDigitales.setAttribute('hidden', true);
}

function close() {
    overlay.classList.remove('active');
    popup.classList.remove('active');
}