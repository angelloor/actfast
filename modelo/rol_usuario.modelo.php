<?php
    require 'conexion.php';

    class RolUsuario{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_rol_usuario, descripcion_rol_usuario from rol_usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>