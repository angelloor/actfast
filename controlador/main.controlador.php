<?php
    require '../modelo/main.modelo.php';

    if($_POST){
        $main = new Main();

        switch($_POST['accion']){
            case "CARGARCATEGORIA":
                echo json_encode($main->cargarCategoria());
            break;
            case "LISTARCATEGORIA":
                $respuesta = $main->listarCategoria();
                echo json_encode($respuesta);
            break;
            case "LISTARACTIVO":
                $respuesta = $main->listarActivo();
                echo json_encode($respuesta);
            break;
            case "LISTARFUNCIONARIOPORCATEGORIA":
                $categoria = $_POST['categoria'];
                $respuesta = $main->listarFuncionarioPorCategoria($categoria);
                echo json_encode($respuesta);
            break;
            
        }
    }
?>