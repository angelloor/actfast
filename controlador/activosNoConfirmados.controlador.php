<?php
    require '../modelo/activosNoConfirmados.modelo.php';

    if($_POST){
        $activosNoConfirmados = new activosNoConfirmados();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($activosNoConfirmados->consultar());
            break;
        }
    }
?>