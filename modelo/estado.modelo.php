<?php
    require 'conexion.php';

    class Estado{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from estado");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM estado where ID_Estado = :idEstado");
            $stmt->bindValue(":idEstado", $idEstado, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM estado where nombre_estado LIKE :patron");
            $stmt->bindValue(":patron", "%".$idEstado."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("INSERT INTO `estado` (`NOMBRE_Estado`) 
                                        VALUES (:nombreEstado);");
            $stmt->bindValue(":nombreEstado",$nombreEstado, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Modificar($idEstado,$nombreEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE `estado` 
                                        SET `NOMBRE_Estado` = :nombreEstado
                                        WHERE `ID_Estado` = :idEstado;");
            $stmt->bindValue(":nombreEstado",$nombreEstado,PDO::PARAM_STR); 
            $stmt->bindValue(":idEstado",$idEstado,PDO::PARAM_INT); 
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }
        }

        public function Eliminar($idEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM estado WHERE ID_Estado = :idEstado");
            $stmt->bindValue(":idEstado",$idEstado, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }
    }
?>