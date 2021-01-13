<?php
    require '../modelo/rol_usuario.modelo.php';

    if($_POST){
        $RolUsuario = new RolUsuario();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($RolUsuario->ConsultarTodo());
            break;
        }
    }
?>