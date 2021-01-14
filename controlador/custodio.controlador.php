<?php
    require '../modelo/custodio.modelo.php';

    if($_POST){
        $custodio = new Custodio();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($custodio->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($custodio->ConsultarPorId($_POST['idCustodio']));
            break;
            case "GUARDAR":
                $nombreCustodio = $_POST['nombreCustodio'];
                if($nombreCustodio == ""){
                    echo json_encode("Ingrese el nombre del custodio");
                    return;
                }
                $respuesta = $custodio->Guardar($nombreCustodio);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreCustodio = $_POST['nombreCustodio'];
                $idCustodio = $_POST['idCustodio'];
                if($nombreCustodio == ""){
                    echo json_encode("Ingrese el nombre del custodio");
                    return;
                }
                $respuesta = $custodio->Modificar($idCustodio,$nombreCustodio);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idCustodio = $_POST['idCustodio'];
                $respuesta = $custodio->Eliminar($idCustodio);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idCustodio = $_POST['idBuscar'];
                $respuesta = $custodio->ConsultarPorIdRow($idCustodio);
                echo json_encode($respuesta);
                return;
            break;
            case "LISTARFUNCIONARIOS":
                $respuesta = $custodio->listarFuncionarios();
                echo json_encode($respuesta);
            break;
            case "CONSULTARREGISTROS":
                $idCustodio = $_POST['idCustodio'];
                $respuesta = $custodio->consultarRegistros($idCustodio);
                echo json_encode($respuesta);
            break;
        }
    }
?>