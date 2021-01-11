<?php
    require 'conexion.php';

    class Cargo{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from cargo");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idCargo){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM cargo where ID_CARGO = :idCargo");
            $stmt->bindValue(":idCargo", $idCargo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idCargo){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from cargo where nombre_cargo like :patron;");
            $stmt->bindValue(":patron", "%".$idCargo."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreCargo){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from cargo where nombre_cargo = :nombreCargo");
            $stmt->bindValue(":nombreCargo", $nombreCargo, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro == 1){
                return "El cargo ya existe ";
            }else{
                $stmt = $conexion->prepare("INSERT INTO `cargo` (`NOMBRE_CARGO`) 
                                            VALUES (:nombreCargo);");
                $stmt->bindValue(":nombreCargo",$nombreCargo, PDO::PARAM_STR);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idCargo,$nombreCargo){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from cargo where nombre_cargo = :nombreCargo");
            $stmt->bindValue(":nombreCargo", $nombreCargo, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro == 1){
                return "El cargo ya existe ";
            }else{
                $stmt = $conexion->prepare("UPDATE `cargo` 
                                SET `NOMBRE_CARGO` = :nombreCargo
                                WHERE `ID_CARGO` = :idCargo;");
                $stmt->bindValue(":nombreCargo",$nombreCargo,PDO::PARAM_STR); 
                $stmt->bindValue(":idCargo",$idCargo,PDO::PARAM_INT); 
                if($stmt->execute()){
                return "OK";
                }else{
                return "Error: se ha generado un error al modificar la información";
                }
            }
        }

        public function Eliminar($idCargo){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM cargo WHERE ID_CARGO = :idCargo");
            $stmt->bindValue(":idCargo",$idCargo, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }
    }
?>