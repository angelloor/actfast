<?php
    require 'conexion.php';

    class RolUsuario{
        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from rol_usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idRolUsuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM rol_usuario where ID_ROL_USUARIO = :idRolUsuario");
            $stmt->bindValue(":idRolUsuario", $idRolUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idRolUsuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM rol_usuario where ID_ROL_USUARIO = :idRolUsuario");
            $stmt->bindValue(":idRolUsuario", $idRolUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreRolUsuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("INSERT INTO `rol_usuario` (`NOMBRE_ROL_USUARIO`) 
                                        VALUES (:nombreRolUsuario);");
            $stmt->bindValue(":nombreRolUsuario",$nombreRolUsuario, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Modificar($idRolUsuario,$nombreRolUsuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE `rol_usuario` 
                                        SET `NOMBRE_ROL_USUARIO` = :nombreRolUsuario
                                        WHERE `ID_ROL_USUARIO` = :idRolUsuario;");
            $stmt->bindValue(":nombreRolUsuario",$nombreRolUsuario,PDO::PARAM_STR); 
            $stmt->bindValue(":idRolUsuario",$idRolUsuario,PDO::PARAM_INT); 
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }
        }

        public function Eliminar($idRolUsuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM rol_usuario WHERE ID_ROL_USUARIO = :idRolUsuario");
            $stmt->bindValue(":idRolUsuario",$idRolUsuario, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }
    }


?>