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
          <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Activos</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="activos.php">Activos</a>
          <a class="dropdown-item" href="categorias.php">Categorías</a>
          <a class="dropdown-item" href="marcas.php">Marcas</a>
          <a class="dropdown-item" href="colores.php">Colores</a>
          <a class="dropdown-item" href="estados.php">Estados</a>
          <a class="dropdown-item" href="custodios.php">Custodios</a>
          <a class="dropdown-item" href="bodegas.php">Bodegas</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="gestionActa.php" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Actas</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="gestionActa.php">Gestion Actas</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Recurso Humano</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="funcionarios.php">Funcionarios</a>
          <a class="dropdown-item" href="unidades.php">Unidades</a>
          <a class="dropdown-item" href="cargos.php">Cargos</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Usuarios</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="usuarios.php">Usuarios</a>
          <a class="dropdown-item" href="roles_usuarios.php">Roles de usuarios </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Reportes</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="./reporteActivo.php">Activos</a>
          <a class="dropdown-item" href="./reporteActa.php">Actas</a>
          <a class="dropdown-item" href="../modelo/activosConfirmados.php" target="blank">Activos Confirmados</a>
          <a class="dropdown-item" href="../modelo/activosNoConfirmados.php" target="blank">Activos No Confirmados</a>
        </div>
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
<div class="container text-center">
  <div class="row text-center">
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/ga.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Generar actas</h5>
              <p class="card-text">Todas la actas con un solo click</p>
              <button id="acta" onclick="acta();" class="btn btn-primary">Acceder</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/au.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Generar actas por usuario </h5>
              <p class="card-text">Solo tienes que seleccionar el usuario y listo!</p>
              <button id="acta" onclick="actaUsuario();" class="btn btn-primary">Acceder</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1">                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/au.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Generar actas usuario y bien</h5>
              <p class="card-text">Genera un acta con el usuario y el bien a cargo</p>
              <button id="acta" onclick="acta();" class="btn btn-primary">Acceder</button>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/ci.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Comprobar Inventario</h5>
              <p class="card-text">Comprueba los activos de la institucion</p>
              <a href="comprobacionInventario.php" class="btn btn-primary">Acceder</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1">                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/rp.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Reportes</h5>
              <p class="card-text">Reporte sobre activos y actas</p>
              <a href="./reporteActa.php" class="btn btn-primary">Acceder</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4 mt-1">                      
          <div class="card-sm width-card" id="card-inicio">
            <img src="../assets/img/ad.png" class="card-img-top mt-3 img-card" alt="Imagen">
            <div class="card-body">
              <h5 class="card-title">Actas Digitales</h5>
              <p class="card-text">Reporte sobre activos y actas</p>
              <a href="./reporteActa.php" class="btn btn-primary">Acceder</a>
            </div>
          </div>
        </div>
  </div>    
</div>
  </body>
</html>




















