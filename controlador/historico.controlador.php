<?php
    require '../modelo/historico.modelo.php';

    if($_POST){
        $historico = new historico();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($historico->consultar());
            break;
            case "CONSULTAR_ID":
                $idActivo = $_POST['idActivo'];
                $fechaHistorico = $_POST['fechaHistorico'];
                echo json_encode($historico->ConsultarPorId($idActivo,$fechaHistorico));
            break;
            case "CONSULTARPORFECHA":
                $fechaInicio = $_POST['fechaInicio'];
                $fechaFinal = $_POST['fechaFinal'];
                echo json_encode($historico->ConsultarPorFecha($fechaInicio,$fechaFinal));
            break;
        }
    }
?>