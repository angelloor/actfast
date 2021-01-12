<?php
    require '../modelo/login.modelo.php';
    if($_SESSION['user'] == ""){
    	header('Location: ../');
    }
    if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){
    	header('Location: ./');
    }
    if($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS"){
    	header('Location: ./');
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
    <script src="../js/funcionario.js"></script>
    <link rel="stylesheet" href="../assets/css/main.css">
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
        <li class="breadcrumb-item active">Recursos Humanos</li>
        <li class="breadcrumb-item active" aria-current="page">Funcionarios</li>
      </ol>
    </nav>
    </div>
  </div>
</div>
<!-- BREADCRUMB -->
  <!-- Gestionar  -->
  <div class="container-fluid">
        <div class="card margin-b-30">
            <div class="card-header bg-primary text-color-white">
                  <h5>Gestionar Funcionarios</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-8 col-xl-8 mt-2">
                        <div class="btn-group-sm">
                            <button class="btn btn-success" id="guardar"  onclick="Guardar();"><span class="fa fa-save"></span>&nbsp&nbspGuardar</button>
                            <button class="btn btn-success" id="modificar" onclick="Modificar();"><span class="fa fa-pencil-alt"></span>&nbsp&nbspModificar</button>
                            <button class="btn btn-primary" id="cancelar" onclick="Cancelar();"><span class="fa fa-ban"></span>&nbsp&nbspCancelar</button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-4 col-xl-4 input-group mt-2">
                      <button class="btn btn-success mr-2" type="submit" onclick="mostrarTodo();"><span class="fa fa-search"></span>&nbsp&nbspMostrar Todo</button>
                      <input class="form-control" id="idFuncionario"  type="search" placeholder="Buscar por Nombre" aria-label="Buscar" autofocus>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="Cedula">Cedula</label>
                        <input type="text" name="cedulaFuncionario" id="cedulaFuncionario" placeholder="Ingrese su número de cedula" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="nombreCompleto">Nombre Completo</label>
                        <input type="text" name="nombreFuncionario" id="nombreFuncionario" placeholder="Apellidos - Nombres" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="Dirección">Dirección</label>
                        <input type="text" name="direccionFuncionario" id="direccionFuncionario" placeholder="Ingrese la dirección" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="Teléfono">Teléfono</label>
                        <input type="text" name="telefonoFuncionario" id="telefonoFuncionario" placeholder="Ingrese el teléfono" class="form-control text-mayus">
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="cargo">Cargo</label>
                        <select name="cargoFuncionario" class="form-control br" id="cargoFuncionario">
                       </select>
                    </div>
                    <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 mt-2">
                        <label for="Unidad">Unidad</label>
                        <select name="unidadFuncionario" class="form-control br" id="unidadFuncionario">
                       </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaFuncionario">
                    <thead>
                        <tr>
                            <th scope="col">Cedula</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Dirección</th>
                            <th scope="col">Teléfono</th>
                            <th scope="col">Cargo</th>
                            <th scope="col">Unidad</th>
                            <th class="th-text-align-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="datos">
                                 
                    </tbody>
                </table>
                <div id="alerta">
                    <div class="alert alert-success text-center" role="alert"> 
                        No se ha encontrado datos
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Gestionar  -->
  </body>
</html>




















