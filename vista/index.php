<?php
    require '../modelo/login.modelo.php';
    if($_SESSION['user'] == ""){
    	header('Location: ../');
    }
?>
<!doctype html>
<html lang="es">
  <head>
    <title>Actfast CNE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="descriptions" content="Sistema para la generación de actas y control de inventario CNE - Delegación Pastaza">
    <meta name="author" content="Angel Miguel Loor Manzano - CODERS">
    <link rel="icon" type="image/png" href="../assets/img/logo.png"/>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <script src="../assets/js/jquery.js"></script>
    <script src="../assets/js/bootstrap.min.js"></script>
    <!-- FONTAWESOME -->
    <link rel="stylesheet" href="../assets/css/all.min.css">
    <!-- SWEET ALERT -->
    <link href="../assets/css/dark.css" rel="stylesheet">
    <script src="../assets/js/sweetalert2.min.js"></script>
    <!-- SCRIPTS -->
    <script src="../assets/js/all.min.js"></script>
    <script src="../assets/js/jquery.js"></script>
    <script src="../js/main.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/popup.css">
  </head>
  <body>
  <!-- header -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <img src="../assets/img/icon.png" class="card-img-top img-nav" alt="Imagen">
      <a class="navbar-brand" href="index.php">&nbsp&nbsp&nbspActfast</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto">
          <li class="nav-item dropdown" <?php if(($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS")){ echo 'style="display:none;"';} ?>>
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gestión de activos</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="activos.php">Activos</a>
          <a class="dropdown-item" href="categorias.php">Categorías</a>
          <a class="dropdown-item" href="marcas.php">Marcas</a>
          <a class="dropdown-item" href="colores.php">Colores</a>
          <a class="dropdown-item" href="estados.php">Estados</a>
          <a class="dropdown-item" href="custodios.php">Custodios</a>
          <a class="dropdown-item" href="bodegas.php">Bodegas</a>
          <a class="dropdown-item" href="sistema.php">Sistemas</a>
        </div>
      </li>
      <li class="nav-item dropdown" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>
        <a class="nav-link dropdown-toggle" href="gestionActa.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gestión de actas</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="gestionActa.php" <?php if($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS"){ echo 'style="display:none;"';} ?>>Asignación de activos</a>
          <a class="dropdown-item" href="actasDigitales.php">Actas digitales</a>
          <a class="dropdown-item" href="firma.php">Firmas</a>
        </div>
      </li>
      <li class="nav-item dropdown" <?php if(($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS")){ echo 'style="display:none;"';} ?>>
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Recurso humano</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="funcionarios.php">Funcionarios</a>
          <a class="dropdown-item" href="unidades.php">Unidades</a>
          <a class="dropdown-item" href="cargos.php">Cargos</a>
        </div>
      </li>
      <li class="nav-item dropdown" <?php if(($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "INVITADO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS")){ echo 'style="display:none;"';} ?>>
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Gestión de usuarios</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="usuarios.php">Usuarios</a>
          <a class="dropdown-item" href="roles_usuarios.php">Roles de usuarios </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="./reporteActivo.php" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>Activos</a>
          <a class="dropdown-item" href="./historico.php" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>Histórico de activos</a>
          <a class="dropdown-item" href="./movimientoActivo.php" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>Movimientos de activos</a>
          <a class="dropdown-item" href="../vista/activosConfirmados.php">Activos confirmados</a>
          <a class="dropdown-item" href="../vista/activosNoConfirmados.php">Activos no confirmados</a>
        </div>
      </li>
      <li class="nav-item dropdown" <?php if(($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO") || ($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS") || ($_SESSION['rolUsuario'] == "INVITADO")){ echo 'style="display:none;"';} ?>>
        <a class="nav-link" href="../backupmysql/backup.php" id="dropdown01" aria-expanded="false" target="_blank">Backup BD</a>
      </li>
          </ul>
          <form class="form-inline my-2 my-lg-0">
          <a class="btn btn-success my-2 my-sm-0" href="../index.php?logout=true"><span class="fa fa-sign-out-alt"></span>&nbsp&nbspSalir<span class="sr-only">(current)</span></a>
          </form>
        </div>
      </nav>
  <!-- header -->
<nav aria-label="breadcrumb bg-light">
  <ol class="breadcrumb bg-transparent">
  <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
  <li class="breadcrumb-item active">Funciones</li>
    </ol>
</nav>
<div class="container text-center margin-b-30">
  <div class="row text-center">
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/ga.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Generar actas</h5>
              <p class="card-text">Genera todas las actas de manera rápida</p>
              <button id="btnCategoria" name="categoria" class="btn-abrir-popup">Acceder</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/au.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Generar actas por funcionario</h5>
              <p class="card-text">Genera las actas de acuerdo a un funcionario seleccionado</p>
              <button id="btnFuncionario" name="funcionario" class="btn-abrir-popup">Acceder</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/ab.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Generar actas por activo</h5>
              <p class="card-text">Genera un acta seleccionando un activo</p>
              <button id="btnActivo" name="activo" class="btn-abrir-popup">Acceder</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4" <?php if($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS"){ echo 'style="display:none;"';} ?>>                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/ci.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Comprobar inventario</h5>
              <p class="card-text">Comprueba los activos de la institución</p>
              <a href="comprobacionInventario.php" class="btn btn-primary">Acceder</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/rp.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Reportes</h5>
              <p class="card-text">Activos, Comprobación de inventario y movimiento de activos</p>
              <button id="btnReporte" name="reporte" class="btn-abrir-popup">Acceder</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1" <?php if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){ echo 'style="display:none;"';} ?>>                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/ad.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Actas digitales</h5>
              <p class="card-text">Genera actas de credenciales digitales de los sistemas</p>
              <button id="btnactasDigitales" name="actasDigitales" class="btn-abrir-popup">Acceder</button>
            </div>
          </div>
        </div>
  </div>    
</div>
<div class="overlay" id="overlay">
        <div class="popup" id="popup">
            <a href="#" class="btn-cerrar-popup" id="btnCerrarPopup"><i class="fas fa-times"></i></a>
            <br>
            <div id="popupBodyCategoria" class="popupBody">
                <h4 class="mb-3">Seleccionar Categor&iacute;a</h4>
                <div class="form">
                    <div class="contenedor-inputs">
                        <select name="SelectCategoria" class="form-control mb-3 tmm" id="SelectCategoria">
                        </select>
                    </div>
                    <button id="BtnGenerarTodasActas" onclick="GenerarTodasActas();" class="btn-submit">Enviar</button>
                </div>
            </div>
            <div id="popupBodyFuncionario" class="popupBody">
                <h4 class="mb-3">Seleccionar la Categor&iacute;a y el Funcionario</h4>
                <div class="form">
                    <div class="contenedor-inputs">
                        <select name="SelectCategoriaDos" class="form-control mb-3 tmm" id="SelectCategoriaDos">
                        </select>
                        <select name="SelectFuncionario" class="form-control mb-3 tmm" id="SelectFuncionario">
                        </select>
                        <h4>Salto de linea</h4>
                        <input type="text" id="saltoLineaDos" name="saltoLineaDos" class="form-control">
                    </div>
                    <button id="BtnGenerarPorUsuario" onclick="GenerarPorFuncionario();" class="btn-submit">Enviar</button>
                </div>
            </div>
            <div id="popupBodyActivo" class="popupBody">
                <h4 class="mb-3">Seleccionar Activo</h4>
                <div class="form">
                    <div class="contenedor-inputs">
                        <label for="activo"></label>
                        <datalist id="activo" name="activo">
                        </datalist>
                        <input id="codigoActivo" list="activo">
                        <h4>Salto de linea</h4>
                        <input type="text" id="saltoLineaTres" name="saltoLineaTres" class="form-control">
                    </div>
                    <button id="BtnGenerarPorActivo" onclick="GenerarPorActivo();" class="btn-submit">Enviar</button>
                </div>
            </div>
            <div id="popupBodyReporte" class="popupBody">
                <h4 class="mb-3">Seleccionar Tipo de Reporte</h4>
                <div class="form">
                    <a class="btn btn-submit col-12 mb-3" href="./reporteActivo.php">Activos</a>
                    <a class="btn btn-submit col-12 mb-3" href="./historico.php">Histórico de activos</a>
                    <a class="btn btn-submit col-12 mb-3" href="./movimientoActivo.php">Movimientos de activos</a>
                    <a class="btn btn-submit col-12 mb-3" href="./activosConfirmados.php">Activos Confirmados</a>
                    <a class="btn btn-submit col-12 mb-3" href="./activosNoConfirmados.php">Activos No Confirmados</a>
                </div>
            </div>
            <div id="popupBodyActasDigitales" class="popupBody">
                <h4 class="mb-3">Seleccionar la Acción</h4>
                <div class="form">
                    <a class="btn btn-submit col-12 mb-3" href="./sistema.php" <?php if($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS"){ echo 'style="display:none;"';} ?>>Sistemas</a>
                    <a class="btn btn-submit col-12 mb-3" href="./actasDigitales.php">Generar Actas</a>
                </div>
            </div>
          </div>
    </div>
<script src="../assets/js/popup.js"></script>
  </body>
</html>




















