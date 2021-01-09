<?php
    require 'conexion.php';

    class Marca{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from marca");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM marca where ID_MARCA = :idMarca");
            $stmt->bindValue(":idMarca", $idMarca, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM marca where nombre_marca LIKE :patron");
            $stmt->bindValue(":patron", "%".$idMarca."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("INSERT INTO `marca` (`NOMBRE_MARCA`) 
                                        VALUES (:nombreMarca);");
            $stmt->bindValue(":nombreMarca",$nombreMarca, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Modificar($idMarca,$nombreMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE `marca` 
                                        SET `NOMBRE_MARCA` = :nombreMarca
                                        WHERE `ID_MARCA` = :idMarca;");
            $stmt->bindValue(":nombreMarca",$nombreMarca,PDO::PARAM_STR); 
            $stmt->bindValue(":idMarca",$idMarca,PDO::PARAM_INT); 
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Eliminar($idMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM marca WHERE ID_Marca = :idMarca");
            $stmt->bindValue(":idMarca",$idMarca, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }
    }
?>