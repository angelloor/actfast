<?php
    require '../modelo/actaDigital.modelo.php';

    if($_POST){
        $sistema = new Sistema();

        switch($_POST['accion']){
            case "CARGARSISTEMAS":
                echo json_encode($sistema->cargarSistemas());
            break;
            case "LISTARFUNCIONARIO":
                $respuesta = $sistema->listarFuncionario();
                echo json_encode($respuesta);
            break;
        }
    }


?>