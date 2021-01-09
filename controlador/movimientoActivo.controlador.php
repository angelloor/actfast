<?php

    require '../modelo/movimientoActivo.modelo.php';

    if($_POST){
        $movimientoActivo = new movimientoActivo();
        switch($_POST["accion"]){
            case "CONSULTAR":
                echo json_encode($movimientoActivo->ConsultarTodo());
            break;
            case "CONSULTARPORFECHA":
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFinal = $_POST['fechaFinal'];
                echo json_encode($movimientoActivo->ConsultarPorFecha($fechaInicio,$fechaFinal));
            break;
        }
    }
?>