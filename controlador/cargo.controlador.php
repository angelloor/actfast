<?php
    require '../modelo/cargo.modelo.php';

    if($_POST){
        $cargo = new Cargo();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($cargo->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($cargo->ConsultarPorId($_POST['idCargo']));
            break;
            case "GUARDAR":
                $nombreCargo = $_POST['nombreCargo'];
                if($nombreCargo == ""){
                    echo json_encode("Ingrese el nombre del cargo");
                    return;
                }
                $respuesta = $cargo->Guardar($nombreCargo);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreCargo = $_POST['nombreCargo'];
                $idCargo = $_POST['idCargo'];

                if($nombreCargo == ""){
                    echo json_encode("Ingrese el nombre del cargo");
                    return;
                }
                $respuesta = $cargo->Modificar($idCargo,$nombreCargo);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idCargo = $_POST['idCargo'];
                $respuesta = $cargo->Eliminar($idCargo);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idCargo = $_POST['idBuscar'];
                $respuesta = $cargo->ConsultarPorIdRow($idCargo);
                echo json_encode($respuesta);
                return;
            break;
            case "CONSULTARREGISTROS":
                $idCargo = $_POST['idCargo'];
                $respuesta = $cargo->consultarRegistros($idCargo);
                echo json_encode($respuesta);
            break;
        }
    }
?>