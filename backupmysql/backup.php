<?php
    require '../modelo/datosConexion.php';

    require '../modelo/login.modelo.php';
    if($_SESSION['user'] == ""){
        header('Location: ../');
    }
    if($_SESSION['rolUsuario'] == "COMPROBADOR DE INVENTARIO"){
        header('Location: ./');
    }
    if($_SESSION['rolUsuario'] == "INVITADO"){
        header('Location: ./');
    }
    if($_SESSION['rolUsuario'] == "GENERADOR DE REPORTES Y ACTAS"){
        header('Location: ./');
    }

    require('mysqldump.php');

    $mysqldump = new MySql($host,$dbname,$user,$pass);
    $file_to_load = 'actfast.sql';
    $mysqldump->backup_tables();
    
?>