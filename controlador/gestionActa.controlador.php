<?php

    require '../modelo/gestionActa.modelo.php';

    if($_POST){
        $gestionActa = new gestionActa();
        switch($_POST["accion"]){
            case "CONSULTAR":
                echo json_encode($gestionActa->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($gestionActa->ConsultarPorId($_POST["idGestionActa"]));
            break;
            case "GUARDAR":
                $idPersona = $_POST["idPersona"];
                $codigoActivo = $_POST["codigoActivo"];
                $custodio = $_POST["custodio"];
                $fecha = $_POST["fecha"];
                if($idPersona == ""){
                        echo json_encode("Seleccione un funcionario para asignar la acta");
                        return;
                    }
                if($codigoActivo == ""){
                        echo json_encode("Seleccione el código del activo");
                        return;
                    }
                if($custodio == ""){
                        echo json_encode("Seleccione el custodio del activo");
                        return;
                    }
                if($fecha == ""){
                        echo json_encode("Seleccione la fecha del acta");
                        return;
                }
                $respuesta = $gestionActa->Guardar($idPersona, $codigoActivo, $custodio, $fecha);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $idPersona = $_POST["idPersona"];
                $codigoActivo = $_POST["codigoActivo"];
                $custodio = $_POST["custodio"];
                $fecha = $_POST["fecha"];
                $idGestionActa = $_POST["idGestionActa"];
                if($idPersona == ""){
                    echo json_encode("Seleccione un funcionario para asignar la acta");
                    return;
                }
                if($codigoActivo == ""){
                    echo json_encode("Seleccione el código del activo");
                    return;
                }
                if($custodio == ""){
                    echo json_encode("Seleccione el custodio del activo");
                    return;
                }
                if($fecha == ""){
                    echo json_encode("Seleccione la fecha del acta");
                    return;
                }
                $respuesta = $gestionActa->Modificar($idGestionActa, $idPersona, $codigoActivo, $custodio, $fecha);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idgestionActa = $_POST["idGestionActa"];
                $respuesta = $gestionActa->Eliminar($idgestionActa);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idGestionActa = $_POST['idGestionActa'];
                $campoBuscar = $_POST['campoBuscar'];
                $respuesta = $gestionActa->ConsultarPorIdRow($idGestionActa,$campoBuscar);
                echo json_encode($respuesta);
                return;
            break;
            case "LISTARFUNCIONARIO":
                $respuesta = $gestionActa->listarFuncionario();
                echo json_encode($respuesta);
            break;
            case "LISTARACTIVO":
                $respuesta = $gestionActa->listarActivo();
                echo json_encode($respuesta);
            break;
            case "LISTARCUSTODIO":
                $respuesta = $gestionActa->listarCustodio();
                echo json_encode($respuesta);
            break;
        }
    }
?>