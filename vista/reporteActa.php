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
    <script src="../assets/js/jquery.dataTables.min.js"></script>
    <script src="../js/reporteActa.js"></script>
  </head>
  <body>
  <!-- HEADER -->
  <?php
      require 'header.php';
  ?>
  <!-- HEADER -->
<!-- BREADCRUMB -->
<div class="container-fluid text-center">
  <div class="row align-items-center">
    <div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-4 mt-2">
        <nav aria-label="breadcrumb bg-light">
      <ol class="breadcrumb bg-transparent">
        <li class="breadcrumb-item"><a href="index.php">Inicio</a></li>
        <li class="breadcrumb-item active">Reportes</li>
        <li class="breadcrumb-item active" aria-current="page">Actas</li>
      </ol>
    </nav>
    </div>
  </div>
</div>
<!-- BREADCRUMB -->
<div class="container-fluid">
    <form action="../modelo/report.php" method="POST" target="blank">
        <div class="card">
            <div class="card-header bg-primary" style="color: white;">
                  <h5>Reporte de Actas</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-xl-8 mt-2">
                        <div class="btn-group-sm">
                            <button class="btn btn-success" id="consultar"><span class="fa fa-file-pdf"></span>&nbsp&nbspConsultar</button>
                            <button class="btn btn-success" id="generar"><span class="fa fa-file-pdf"></span>&nbsp&nbspPdf</button>
                            <button class="btn btn-success" id="excel"><span class="fa fa-file-pdf"></span>&nbsp&nbspExcel</button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 mt-3">
                        <label for="categoria">Categoria</label>
                        <select name="categoria" class="form-control" style="border-radius: 5px;" id="categoria">
                       </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 mt-3">
                        <label for="marca">Marca</label>
                        <select name="marca" class="form-control" style="border-radius: 5px;" id="marca">
                       </select>
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 mt-3">
                        <label for="estado">Estado</label>
                        <select name="estado" class="form-control" style="border-radius: 5px;" id="estado">
                       </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="custodio">Custodio</label>
                        <select name="custodio" class="form-control" style="border-radius: 5px;" id="custodio">
                       </select>
                    </div>
                    <div class="col-md-6 mt-2">
                        <label for="funcionario">Funcionario</label>
                        <select name="funcionario" class="form-control" style="border-radius: 5px;" id="funcionario">
                       </select>
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
    <!-- Gestionar  -->
</html>