<?php
    require '../modelo/bodega.modelo.php';

    if($_POST){
        $bodega = new Bodega();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($bodega->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($bodega->ConsultarPorId($_POST['idBodega']));
            break;
            case "GUARDAR":
                $nombreBodega = $_POST['nombreBodega'];
                $ubicacion = $_POST['ubicacion'];
                $nombreResponsable = $_POST['nombreResponsable'];
                if($nombreBodega == "" ){
                    echo json_encode("Ingrese el nombre de la Bodega");
                    return;
                }
                if($ubicacion == "" ){
                    echo json_encode("Ingrese la ubicacion de la Bodega");
                    return;
                }
                if($nombreResponsable == "" ){
                    echo json_encode("Ingrese el responsable de la Bodega");
                    return;
                }
                $respuesta = $bodega->Guardar($nombreBodega,$ubicacion,$nombreResponsable);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreBodega = $_POST['nombreBodega'];
                $ubicacion = $_POST['ubicacion'];
                $nombreResponsable = $_POST['nombreResponsable'];
                $idBodega = $_POST['idBodega'];
                if($nombreBodega == "" ){
                    echo json_encode("Ingrese el nombre de la Bodega");
                    return;
                }
                if($ubicacion == "" ){
                    echo json_encode("Ingrese la ubicacion de la Bodega");
                    return;
                }
                if($nombreResponsable == "" ){
                    echo json_encode("Ingrese el responsable de la Bodega");
                    return;
                }
                $respuesta = $bodega->Modificar($idBodega,$nombreBodega,$ubicacion,$nombreResponsable);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idBodega = $_POST['idBodega'];
                $respuesta = $bodega->Eliminar($idBodega);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idBodega = $_POST['idBuscar'];
                $respuesta = $bodega->ConsultarPorIdRow($idBodega);
                echo json_encode($respuesta);
                return;
            break;
            case "LISTARRESPONSABLEBODEGA":
                $respuesta = $bodega->listarResponsableBodega();
                echo json_encode($respuesta);
            break;
            case "CONSULTARREGISTROS":
                $idBodega = $_POST['idBodega'];
                $respuesta = $bodega->consultarRegistros($idBodega);
                echo json_encode($respuesta);
            break;
        }
    }
?>