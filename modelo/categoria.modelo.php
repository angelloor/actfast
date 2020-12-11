<?php
    require 'conexion.php';

    class Categoria{
        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from categoria");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idCategoria){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM categoria where ID_CATEGORIA = :idCategoria");
            $stmt->bindValue(":idCategoria", $idCategoria, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idCategoria){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM categoria where nombre_categoria LIKE :patron");
            $stmt->bindValue(":patron", "%".$idCategoria."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreCategoria, $descripcionCategoria){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("INSERT INTO `categoria` (`NOMBRE_CATEGORIA`, `DESCRIPCION_CATEGORIA`)
                                        VALUES (:nombreCategoria, :descripcionCategoria);");
            $stmt->bindValue(":nombreCategoria",$nombreCategoria, PDO::PARAM_STR);
            $stmt->bindValue(":descripcionCategoria",$descripcionCategoria, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Modificar($idCategoria,$nombreCategoria, $descripcionCategoria){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE `categoria` 
                                        SET `NOMBRE_CATEGORIA` = :nombreCategoria,
                                         `DESCRIPCION_CATEGORIA` = :descripcionCategoria
                                        WHERE `ID_CATEGORIA` = :idCategoria;");
             $stmt->bindValue(":nombreCategoria",$nombreCategoria, PDO::PARAM_STR);
             $stmt->bindValue(":descripcionCategoria",$descripcionCategoria, PDO::PARAM_STR);
            $stmt->bindValue(":idCategoria",$idCategoria,PDO::PARAM_INT); 
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }
        }

        public function Eliminar($idCategoria){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM categoria WHERE ID_CATEGORIA = :idCategoria");
            $stmt->bindValue(":idCategoria",$idCategoria, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }
    }


?>