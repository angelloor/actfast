<?php
    require 'conexion.php';
    session_start();

    class Login{

        public function consultarUsuario($usuario, $clave){

            $conexion =  new Conexion();
            $stmt = $conexion->prepare("select u.id_usuario, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario from usuario u inner join persona p on u.persona_id = p.id_persona inner join rol_usuario ru on u.rol_usuario_id = ru.id_rol_usuario where nombre_usuario = :usuario");
            $stmt->bindValue(":usuario",$usuario,PDO::PARAM_STR); 
            $stmt->execute();
            $datos = $stmt->fetch(PDO::FETCH_ASSOC);
            
            if($datos['clave'] == $clave){
                $_SESSION['user'] = $datos['nombre_usuario'];
                return "OK";
            }else{
                return "Usuario o contraseña incorrectos";
            }
        }
    }
?>