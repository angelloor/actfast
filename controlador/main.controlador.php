<?php
    require '../modelo/main.modelo.php';

    if($_POST){
        $main = new Main();

        switch($_POST['accion']){
            case "CARGARCATEGORIA":
                echo json_encode($main->cargarCategoria());
            break;
        }
    }
?>