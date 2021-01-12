<?php
    require 'conexion.php';

    class Unidad{
        
        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from unidad order by nombre_unidad asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idUnidad){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM unidad where ID_UNIDAD = :idUnidad");
            $stmt->bindValue(":idUnidad", $idUnidad, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idUnidad){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from unidad where nombre_unidad like :patron order by nombre_unidad asc");
            $stmt->bindValue(":patron", "%".$idUnidad."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreUnidad){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from unidad where nombre_unidad = :nombreUnidad");
            $stmt->bindValue(":nombreUnidad", $nombreUnidad, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro >= 1){
                return "La unidad ya existe ";
            }else{
                $stmt = $conexion->prepare("INSERT INTO `unidad` (`NOMBRE_UNIDAD`) 
                                            VALUES (:nombreUnidad);");
                $stmt->bindValue(":nombreUnidad",$nombreUnidad, PDO::PARAM_STR);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idUnidad,$nombreUnidad){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from unidad where nombre_unidad = :nombreUnidad");
            $stmt->bindValue(":nombreUnidad", $nombreUnidad, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro >= 1){
                return "La unidad ya existe ";
            }else{
                $stmt = $conexion->prepare("UPDATE `unidad` 
                                SET `NOMBRE_UNIDAD` = :nombreUnidad
                                WHERE `ID_UNIDAD` = :idUnidad;");
                $stmt->bindValue(":nombreUnidad",$nombreUnidad,PDO::PARAM_STR); 
                $stmt->bindValue(":idUnidad",$idUnidad,PDO::PARAM_INT); 
                if($stmt->execute()){
                return "OK";
                }else{
                return "Error: se ha generado un error al modificar la información";
                }
            }
        }

        public function Eliminar($idUnidad){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM unidad WHERE ID_UNIDAD = :idUnidad");
            $stmt->bindValue(":idUnidad",$idUnidad, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function consultarRegistros($idUnidad){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) as registros from persona where unidad_id = :idUnidad;");
            $stmt->bindValue(":idUnidad",$idUnidad, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>