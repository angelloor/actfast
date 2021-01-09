<?php

    require '../modelo/comprobacionInventario.modelo.php';

    if($_POST){
        $comprobacionInventario = new comprobacionInventario();
        switch($_POST["accion"]){
            case "CONSULTARDATOS":
                $codigoActivo = $_POST['codigoActivo'];
                if($codigoActivo == ""){
                    echo json_encode("Ingrese el codigo del activo");
                    return;
                }
                echo json_encode($comprobacionInventario->Consultar($codigoActivo));
            break;
            case "LISTARFUNCIONARIO":
                $respuesta = $comprobacionInventario->listarFuncionario();
                echo json_encode($respuesta);
            break;
            case "LISTARESTADO":
                $respuesta = $comprobacionInventario->listarEstado();
                echo json_encode($respuesta);
            break;
            case "GUARDAR":
                $codigo = $_POST['codigo'];
                $estado = $_POST['estado'];
                $funcionario = $_POST['funcionario'];
                $comentario = $_POST['comentario'];

                $respuesta = $comprobacionInventario->Guardar($codigo,$estado,$funcionario,$comentario);
                echo json_encode($respuesta);
            break;
            case "RESTABLECER":
                $respuesta = $comprobacionInventario->Restablecer();
                echo json_encode($respuesta);
            break;
        }
    }
?>