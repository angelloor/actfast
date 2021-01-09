<?php
    require 'conexion.php';

    class Color{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from color");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idColor){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM color where ID_COLOR = :idColor");
            $stmt->bindValue(":idColor", $idColor, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idColor){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM color where nombre_color LIKE :patron");
            $stmt->bindValue(":patron", "%".$idColor."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreColor){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("INSERT INTO `color` (`NOMBRE_COLOR`) 
                                        VALUES (:nombreColor);");
            $stmt->bindValue(":nombreColor",$nombreColor, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Modificar($idColor,$nombreColor){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE `color` 
                                        SET `NOMBRE_COLOR` = :nombreColor
                                        WHERE `ID_COLOR` = :idColor;");
            $stmt->bindValue(":nombreColor",$nombreColor,PDO::PARAM_STR); 
            $stmt->bindValue(":idColor",$idColor,PDO::PARAM_INT); 
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }
        }

        public function Eliminar($idColor){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM color WHERE ID_COLOR = :idColor");
            $stmt->bindValue(":idColor",$idColor, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }
    }
?>