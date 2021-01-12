<?php
    require '../modelo/color.modelo.php';

    if($_POST){
        $color = new Color();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($color->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($color->ConsultarPorId($_POST['idColor']));
            break;
            case "GUARDAR":
                $nombreColor = $_POST['nombreColor'];
                if($nombreColor == ""){
                    echo json_encode("Ingrese el nombre del Color");
                    return;
                }
                $respuesta = $color->Guardar($nombreColor);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreColor = $_POST['nombreColor'];
                $idColor = $_POST['idColor'];
                if($nombreColor == ""){
                    echo json_encode("Ingrese el nombre del Color");
                    return;
                }
                $respuesta = $color->Modificar($idColor,$nombreColor);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idColor = $_POST['idColor'];
                $respuesta = $color->Eliminar($idColor);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idColor = $_POST['idBuscar'];
                $respuesta = $color->ConsultarPorIdRow($idColor);
                echo json_encode($respuesta);
                return;
            break;
            case "CONSULTARREGISTROS":
                $idColor = $_POST['idColor'];
                $respuesta = $color->consultarRegistros($idColor);
                echo json_encode($respuesta);
            break;
        }
    }
?>