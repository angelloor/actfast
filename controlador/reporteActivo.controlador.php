<?php

    require '../modelo/reporteActivo.modelo.php';

    if($_POST){
        $reporteActivo = new reporteActivo();

        switch($_POST["accion"]){
            case "LISTARCATEGORIA":
                $respuesta = $reporteActivo->listarCategoria();
                echo json_encode($respuesta);
            break;
            case "LISTARMARCA":
                $respuesta = $reporteActivo->listarMarca();
                echo json_encode($respuesta);
            break;
            case "LISTARESTADO":
                $respuesta = $reporteActivo->listarEstado();
                echo json_encode($respuesta);
            break;
            case "LISTARCUSTODIO":
                $respuesta = $reporteActivo->listarCustodio();
                echo json_encode($respuesta);
            break;
            case "LISTARFUNCIONARIO":
                $respuesta = $reporteActivo->listarFuncionario();
                echo json_encode($respuesta);
            break;
        }
    }
?>