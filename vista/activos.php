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
    <script src="../js/activo.js"></script>
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
        <li class="breadcrumb-item active">Activos</li>
        <li class="breadcrumb-item active" aria-current="page">Activos</li>
      </ol>
    </nav>
    </div>
  </div>
</div>
<!-- BREADCRUMB -->
<!-- Gestionar  -->
<div class="container-fluid">
        <div class="card">
            <div class="card-header bg-primary text-color-white">
                  <h5>Gestionar Activos</h5>
            </div>
            <div class="card-body">
            <div class="row">
                    <div class="col-12 col-sm-12 col-md-7 col-xl-7 mt-2">
                        <div class="btn-group-sm">
                            <button class="btn btn-success" id="guardar"  onclick="Guardar();"><span class="fa fa-save"></span>&nbsp&nbspGuardar</button>
                            <button class="btn btn-success" id="modificar" onclick="Modificar();"><span class="fa fa-pencil-alt"></span>&nbsp&nbspModificar</button>
                            <button class="btn btn-primary" id="cancelar" onclick="Cancelar();"><span class="fa fa-pencil-alt"></span>&nbsp&nbspCancelar</button>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-5 col-xl-5">
                        <div class="btn-toolbar pc-flex-end">
                            <div class="btn-group mt-2">
                                <button class="btn btn-success mr-2" type="submit" onclick="mostrarTodo();"><span class="fa fa-search"></span>&nbsp&nbspMostrar Todo</button>
                            </div>
                            <div class="input-group mt-2">
                                <select name="campoBuscar" id="campoBuscar" class="form-control mr-2">
                                    <option>Codigo</option>
                                    <option>Nombre</option>
                                    <option>Marca</option>
                                    <option>Modelo</option>
                                    <option>Serie</option>
                                </select>
                                <input class="form-control" id="idActivo"  type="search" placeholder="Buscar" aria-label="Buscar" autofocus>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="categoria">Categoría</label>
                        <select name="categoria" id="categoria" class="form-control br">
                       </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="marca">Marca</label>
                        <select name="marca" id="marca" class="form-control br">
                       </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="estado"><strong>Estado</strong></label>
                        <select name="estado" id="estado" class="form-control br">
                       </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="color">Color</label>
                        <select name="color" id="color" class="form-control br">
                       </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="caracteristica"><strong>Características</strong></label>
                        <input type="text" name="caracteristica" id="caracteristica" placeholder="Por favor ingrese las características" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="bodega">Bodega</label>
                        <select name="bodega" id="bodega" class="form-control br">
                       </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="custodio">Custodio</label>
                        <select name="custodio" id="custodio" class="form-control br">
                       </select>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="codigo"><strong>Codigo</strong></label>
                        <input type="text" name="codigo" id="codigo" placeholder="Por favor ingrese el codigo" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="nombre">Nombre</label>
                        <input type="text" name="nombre" id="nombre" placeholder="Por favor ingrese el nombre" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="modelo">Modelo</label>
                        <input type="text" name="modelo" id="modelo" placeholder="Por favor ingrese el modelo" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="serie">Serie</label>
                        <input type="text" name="serie" id="serie" placeholder="Por favor ingrese la serie" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="origenIngreso">Origen de Ingreso</label>
                        <input type="text" name="origenIngreso" id="origenIngreso" placeholder="Por favor ingrese el origen de ingreso" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="fechaIngreso">Fecha de Ingreso</label>
                        <input type="date" name="fechaIngreso" id="fechaIngreso" placeholder="Por favor ingrese la fecha de ingreso" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="valorCompra">Valor de compra</label>
                        <input type="text" name="valorCompra" id="valorCompra" placeholder="Por favor ingrese el valor de la compra" class="form-control">
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="comentario"><strong>Comentario</strong></label>
                        <textarea name="comentario" id="comentario" cols="60" rows="1" placeholder="Por favor ingrese un comentario" class="form-control"></textarea>
                    </div>
                    <div class="col-12 col-sm-12- col-md-4 col-lg-3 col-xl-3 mt-2">
                        <label for="comprobacionInventario"><strong>Comprobacion Inventario</strong></label>
                        <select name="comprobacionInventario" id="comprobacionInventario" class="form-control br">
                            <option>SI</option>
                            <option>NO</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <table class="table tabled-bordered table-sm" id="tablaActivo">
                    <thead>
                        <tr>
                            <th scope="col">Codigo</th>
                            <th scope="col">Nombre</th>
                            <th scope="col">Categoría</th>
                            <th scope="col">Caracteristica</th>
                            <th scope="col">Marca</th>
                            <th scope="col">Modelo</th>
                            <th scope="col">Serie</th>
                            <th scope="col">Estado</th>
                            <th scope="col">CI</th>
                            <th scope="col">Acciones</th>
                        </tr>
                    </thead>
                    <tbody id="datos">
                                  
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Gestionar  -->
  </body>
</html>




















