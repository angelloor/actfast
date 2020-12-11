<?php

    require '../modelo/usuario.modelo.php';

    if($_POST){
        $usuario = new Usuario();

        switch($_POST["accion"]){
            case "CONSULTAR":
                echo json_encode($usuario->ConsultarTodo());
            break;
            case "CONSULTAR_ID":
                echo json_encode($usuario->ConsultarPorId($_POST["idUsuario"]));
            break;
            case "GUARDAR":
                $idPersona = $_POST["idPersona"];
                $nombre = $_POST["nombre"];
                $clave = $_POST["clave"];
                $rol = $_POST["rol"];

              if($idPersona == ""){
                    echo json_encode("Debe ingresar la persona asignada para este usuario");
                    return;
                }
              if($nombre == ""){
                    echo json_encode("Debe ingresar el nombre del usuario");
                    return;
                }
              if($clave == ""){
                    echo json_encode("Debe ingresar la la clave del usuario");
                    return;
                }
              if($rol == ""){
                    echo json_encode("Debe ingresar el rol del usuario");
                    return;
                }
                $respuesta = $usuario->Guardar($idPersona, $nombre, $clave, $rol);
                echo json_encode($respuesta);
            break;
            case "MODIFICAR":
                $idPersona = $_POST["idPersona"];
                $nombre = $_POST["nombre"];
                $clave = $_POST["clave"];
                $rol = $_POST["rol"];
                $idUsuario = $_POST["idUsuario"];
              if($idPersona == ""){
                    echo json_encode("Debe ingresar la persona asignada para este usuario");
                    return;
                }
              if($nombre == ""){
                    echo json_encode("Debe ingresar el nombre del usuario");
                    return;
                }
              if($clave == ""){
                    echo json_encode("Debe ingresar la la clave del usuario");
                    return;
                }
              if($rol == ""){
                    echo json_encode("Debe ingresar el rol del usuario");
                    return;
                }
                $respuesta = $usuario->Modificar($idUsuario, $idPersona, $nombre, $clave, $rol);
                echo json_encode($respuesta);
            break;
            case "ELIMINAR":
                $idUsuario = $_POST["idUsuario"];
                $respuesta = $usuario->Eliminar($idUsuario);
                echo json_encode($respuesta);
            break;
            case "CONSULTAR_ID_ROW":
                $idBuscar = $_POST["idBuscar"];
                $respuesta = $usuario->ConsultarPorIdRow($idBuscar);
                echo json_encode($respuesta);
            break;
            case "LISTARFUNCIONARIOS":
                $respuesta = $usuario->listarFuncionarios();
                echo json_encode($respuesta);
            break;
            case "LISTARROLES":
                $respuesta = $usuario->listarRoles();
                echo json_encode($respuesta);
            break;
        }
    }
?>