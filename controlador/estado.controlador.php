<?php
    require '../modelo/estado.modelo.php';

    if($_POST){
        $estado = new Estado();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($estado->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($estado->ConsultarPorId($_POST['idEstado']));
            break;
            case "GUARDAR":
                $nombreEstado = $_POST['nombreEstado'];
                if($nombreEstado == ""){
                    echo json_encode("Ingrese el nombre de Estado");
                    return;
                }
                $respuesta = $estado->Guardar($nombreEstado);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreEstado = $_POST['nombreEstado'];
                $idEstado = $_POST['idEstado'];
                if($nombreEstado == ""){
                    echo json_encode("Ingrese el nombre de Estado");
                    return;
                }
                $respuesta = $estado->Modificar($idEstado,$nombreEstado);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idEstado = $_POST['idEstado'];
                $respuesta = $estado->Eliminar($idEstado);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idEstado = $_POST['idBuscar'];
                $respuesta = $estado->ConsultarPorIdRow($idEstado);
                echo json_encode($respuesta);
                return;
            break;
        }
    }
?>