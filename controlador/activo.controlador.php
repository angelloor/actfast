<?php
    require '../modelo/activo.modelo.php';

    if($_POST){
        $activo = new Activo();

        switch($_POST['accion']){
            case "CONSULTAR":
                echo json_encode($activo->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($activo->ConsultarPorId($_POST['idActivo']));
            break;
            case "GUARDAR":
                $categoria = $_POST['categoria'];
                $marca = $_POST['marca'];
                $estado = $_POST['estado'];
                $color = $_POST['color'];
                $caracteristica = $_POST['caracteristica'];
                $bodega = $_POST['bodega'];
                $custodio = $_POST['custodio'];
                $codigo = $_POST['codigo'];
                $nombre = $_POST['nombre'];
                $modelo = $_POST['modelo'];
                $serie = $_POST['serie'];
                $origenIngreso = $_POST['origenIngreso'];
                $fechaIngreso = $_POST['fechaIngreso'];
                $valorCompra = $_POST['valorCompra'];
                $comentario = $_POST['comentario'];
                $comprobacionInventario = $_POST['comprobacionInventario'];
                
                if($categoria == ""){
                    echo json_encode("Seleccione la categoria");
                    return;
                }
                if($marca == ""){
                    echo json_encode("Seleccione la marca");
                    return;
                }
                if($estado == ""){
                    echo json_encode("Seleccione el estado");
                    return;
                }
                if($color == ""){
                    echo json_encode("Seleccione el color");
                    return;
                }
                if($caracteristica == ""){
                    echo json_encode("Ingrese la caracteristica");
                    return;
                }
                if($bodega == ""){
                    echo json_encode("Ingrese la bodega");
                    return;
                }
                if($custodio == ""){
                    echo json_encode("Seleccione el custodio");
                    return;
                }
                if($codigo == ""){
                    echo json_encode("Ingrese el codigo");
                    return;
                }
                if($nombre == ""){
                    echo json_encode("Ingrese el nombre");
                    return;
                }
                if($modelo == ""){
                    echo json_encode("Ingrese el modelo");
                    return;
                }
                if($serie == ""){
                    echo json_encode("Ingrese el numero de serie");
                    return;
                }
                if($origenIngreso == ""){
                    echo json_encode("Ingrese el origen del ingreso");
                    return;
                }
                if($fechaIngreso == ""){
                    echo json_encode("Seleccione la fecha del ingreso");
                    return;
                }
                if($valorCompra == ""){
                    echo json_encode("Ingrese el valor de la compra");
                    return;
                }
                if($comprobacionInventario == ""){
                    echo json_encode("Seleccione la comprobacion de Inventario");
                    return;
                }

                $respuesta = $activo->Guardar($categoria,$marca ,$estado,$color,$caracteristica,$bodega,$custodio,$codigo,$nombre,$modelo,$serie,$origenIngreso,$fechaIngreso,$valorCompra,$comentario,$comprobacionInventario);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $categoria = $_POST['categoria'];
                $marca = $_POST['marca'];
                $estado = $_POST['estado'];
                $color = $_POST['color'];
                $caracteristica = $_POST['caracteristica'];
                $bodega = $_POST['bodega'];
                $custodio = $_POST['custodio'];
                $codigo = $_POST['codigo'];
                $nombre = $_POST['nombre'];
                $modelo = $_POST['modelo'];
                $serie = $_POST['serie'];
                $origenIngreso = $_POST['origenIngreso'];
                $fechaIngreso = $_POST['fechaIngreso'];
                $valorCompra = $_POST['valorCompra'];
                $comentario = $_POST['comentario'];
                $comprobacionInventario = $_POST['comprobacionInventario'];
                $idActivo = $_POST['idActivo'];
                
                if($categoria == ""){
                    echo json_encode("Seleccione la categoria");
                    return;
                }
                if($marca == ""){
                    echo json_encode("Seleccione la marca");
                    return;
                }
                if($estado == ""){
                    echo json_encode("Seleccione el estado");
                    return;
                }
                if($color == ""){
                    echo json_encode("Seleccione el color");
                    return;
                }
                if($caracteristica == ""){
                    echo json_encode("Ingrese la caracteristica");
                    return;
                }
                if($bodega == ""){
                    echo json_encode("Ingrese la bodega");
                    return;
                }
                if($custodio == ""){
                    echo json_encode("Seleccione el custodio");
                    return;
                }
                if($codigo == ""){
                    echo json_encode("Ingrese el codigo");
                    return;
                }
                if($nombre == ""){
                    echo json_encode("Ingrese el nombre");
                    return;
                }
                if($modelo == ""){
                    echo json_encode("Ingrese el modelo");
                    return;
                }
                if($serie == ""){
                    echo json_encode("Ingrese el numero de serie");
                    return;
                }
                if($origenIngreso == ""){
                    echo json_encode("Ingrese el origen del ingreso");
                    return;
                }
                if($fechaIngreso == ""){
                    echo json_encode("Seleccione la fecha del ingreso");
                    return;
                }
                if($valorCompra == ""){
                    echo json_encode("Ingrese el valor de la compra");
                    return;
                }
                if($comprobacionInventario == ""){
                    echo json_encode("Seleccione la comprobacion de Inventario");
                    return;
                }
        
                $respuesta = $activo->Modificar($idActivo,$categoria,$marca ,$estado,$color,$caracteristica,$bodega,$custodio,$codigo,$nombre,$modelo,$serie,$origenIngreso,$fechaIngreso,$valorCompra,$comentario,$comprobacionInventario);
                echo json_encode($respuesta);

            break;
            case "ELIMINAR":
                $idActivo = $_POST['idActivo'];
                $respuesta = $activo->Eliminar($idActivo);
                echo json_encode($respuesta);
            break;

            case "CONSULTAR_ID_ROW":
                $idBuscar = $_POST['idActivo'];
                $campoBuscar = $_POST['campoBuscar'];
                $respuesta = $activo->ConsultarPorIdRow($idBuscar,$campoBuscar);
                echo json_encode($respuesta);
                return;
            break;
            case "LISTARCATEGORIA":
                $respuesta = $activo->listarCategoria();
                echo json_encode($respuesta);
            break;
            case "LISTARMARCA":
                $respuesta = $activo->listarMarca();
                echo json_encode($respuesta);
            break;
            case "LISTARESTADO":
                $respuesta = $activo->listarEstado();
                echo json_encode($respuesta);
            break;
            case "LISTARCOLOR":
                $respuesta = $activo->listarColor();
                echo json_encode($respuesta);
            break;
            case "LISTARBODEGA":
                $respuesta = $activo->listarBodega();
                echo json_encode($respuesta);
            break;
            case "LISTARCUSTODIO":
                $respuesta = $activo->listarCustodio();
                echo json_encode($respuesta);
            break;
        }
    }


?>