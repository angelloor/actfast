<?php
    require 'conexion.php';
    session_start();

    class Login{

        public function consultarUsuario($usuario, $clave){

            $conexion =  new Conexion();

            $stmt = $conexion->prepare("SELECT COUNT(*) FROM usuario WHERE NOMBRE_USUARIO = :usuario");
            $stmt->bindValue(":usuario",$usuario,PDO::PARAM_STR);
            $stmt->execute();
            $usuarioExiste = $stmt->fetch(PDO::FETCH_ASSOC);

            if($usuarioExiste['COUNT(*)'] == 0 ){
                return "El usuario no existe";
            }else{
                $stmt = $conexion->prepare("SELECT u.id_usuario, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario FROM usuario u INNER JOIN persona p ON u.persona_id = p.id_persona INNER JOIN rol_usuario ru ON u.rol_usuario_id = ru.id_rol_usuario WHERE nombre_usuario = :usuario");
                $stmt->bindValue(":usuario",$usuario,PDO::PARAM_STR); 
                $stmt->execute();
                $datos = $stmt->fetch(PDO::FETCH_ASSOC);
                if($datos['clave'] == $clave){
                    $_SESSION['user'] = $datos['nombre_usuario'];
                    return "OK";
                }else{
                    return "Usuario o contraseña incorrectos".$datos['clave']." - ".$clave;
                    return "Contraseña incorrecta";
                }
            }
        }
    }
?>