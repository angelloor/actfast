<?php
    require '../modelo/categoria.modelo.php';

    if($_POST){
        $categoria = new Categoria();
        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($categoria->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($categoria->ConsultarPorId($_POST['idCategoria']));
            break;
            case "GUARDAR":
                $nombreCategoria = $_POST['nombreCategoria'];
                $descripcionCategoria = $_POST['descripcionCategoria'];
                if($nombreCategoria == ""){
                    echo json_encode("Ingrese el nombre de la categoría");
                    return;
                }
                if($descripcionCategoria == ""){
                    echo json_encode("Ingrese la descripción de la categoría");
                    return;
                }
                $respuesta = $categoria->Guardar($nombreCategoria,$descripcionCategoria);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $nombreCategoria = $_POST['nombreCategoria'];
                $descripcionCategoria = $_POST['descripcionCategoria'];
                $idCategoria = $_POST['idCategoria'];
                if($nombreCategoria == ""){
                    echo json_encode("Ingrese el nombre de la categoría");
                    return;
                }
                if($descripcionCategoria == ""){
                    echo json_encode("Ingrese la descripción de la categoría");
                    return;
                }
                $respuesta = $categoria->Modificar($idCategoria,$nombreCategoria,$descripcionCategoria);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idCategoria = $_POST['idCategoria'];
                $respuesta = $categoria->Eliminar($idCategoria);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idCategoria = $_POST['idBuscar'];
                $respuesta = $categoria->ConsultarPorIdRow($idCategoria);
                echo json_encode($respuesta);
                return;
            break;
            case "CONSULTARREGISTROS":
            $idCategoria = $_POST['idCategoria'];
            $respuesta = $categoria->consultarRegistros($idCategoria);
            echo json_encode($respuesta);
            break;
        }
    }
?>