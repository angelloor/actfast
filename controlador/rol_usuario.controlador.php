<?php
    require '../modelo/rol_usuario.modelo.php';

    if($_POST){
        $RolUsuario = new RolUsuario();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($RolUsuario->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($RolUsuario->ConsultarPorId($_POST['idRolUsuario']));
            break;
            case "GUARDAR":
                $nombreRolUsuario = $_POST['nombreRolUsuario'];
                if($nombreRolUsuario == ""){
                    echo json_encode("Ingrese el nombre de rol de usuario");
                    return;
                }
                $respuesta = $RolUsuario->Guardar($nombreRolUsuario);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreRolUsuario = $_POST['nombreRolUsuario'];
                $idRolUsuario = $_POST['idRolUsuario'];
                if($nombreRolUsuario == ""){
                    echo json_encode("Ingrese el nombre de rol de usuario");
                    return;
                }
                $respuesta = $RolUsuario->Modificar($idRolUsuario,$nombreRolUsuario);
                echo json_encode($respuesta);

            break;
            case "ELIMINAR":
                $idRolUsuario = $_POST['idRolUsuario'];
                $respuesta = $RolUsuario->Eliminar($idRolUsuario);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idRolUsuario = $_POST['idBuscar'];
                $respuesta = $RolUsuario->ConsultarPorIdRow($idRolUsuario);
                echo json_encode($respuesta);
                return;
            break;
        }
    }
?>