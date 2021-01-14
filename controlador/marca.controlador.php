<?php
    require '../modelo/marca.modelo.php';

    if($_POST){
        $marca = new Marca();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($marca->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($marca->ConsultarPorId($_POST['idMarca']));
            break;
            case "GUARDAR":
                $nombreMarca = $_POST['nombreMarca'];
                if($nombreMarca == ""){
                    echo json_encode("Ingrese el nombre de la marca");
                    return;
                }
                $respuesta = $marca->Guardar($nombreMarca);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreMarca = $_POST['nombreMarca'];
                $idMarca = $_POST['idMarca'];
                if($nombreMarca == ""){
                    echo json_encode("Ingrese el nombre de la marca");
                    return;
                }
                $respuesta = $marca->Modificar($idMarca,$nombreMarca);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idMarca = $_POST['idMarca'];
                $respuesta = $marca->Eliminar($idMarca);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idMarca = $_POST['idBuscar'];
                $respuesta = $marca->ConsultarPorIdRow($idMarca);
                echo json_encode($respuesta);
                return;
            break;
            case "CONSULTARREGISTROS":
            $idMarca = $_POST['idMarca'];
            $respuesta = $marca->consultarRegistros($idMarca);
            echo json_encode($respuesta);
            break;
        }
    }
?>