<?php
    require '../modelo/unidad.modelo.php';

    if($_POST){
        $unidad = new Unidad();

        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($unidad->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($unidad->ConsultarPorId($_POST['idUnidad']));
            break;
            case "GUARDAR":
                $nombreUnidad = $_POST['nombreUnidad'];

                if($nombreUnidad == ""){
                    echo json_encode("Ingrese el nombre de la unidad");
                    return;
                }
                $respuesta = $unidad->Guardar($nombreUnidad);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreUnidad = $_POST['nombreUnidad'];
                $idUnidad = $_POST['idUnidad'];

                if($nombreUnidad == ""){
                    echo json_encode("Ingrese el nombre de la unidad");
                    return;
                }
        
                $respuesta = $unidad->Modificar($idUnidad,$nombreUnidad);
                echo json_encode($respuesta);

            break;
            case "ELIMINAR":
                $idUnidad = $_POST['idUnidad'];
                $respuesta = $unidad->Eliminar($idUnidad);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idUnidad = $_POST['idBuscar'];
                $respuesta = $unidad->ConsultarPorIdRow($idUnidad);
                echo json_encode($respuesta);
                return;
            break;
        }
    }


?>