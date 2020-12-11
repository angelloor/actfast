<?php
    require 'conexion.php';

    class Bodega{
        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, p.nombre_persona from bodega b inner join persona p on b.responsable_bodega = p.id_persona order by id_bodega asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idBodega){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, p.nombre_persona from bodega b inner join persona p on b.responsable_bodega = p.id_persona where ID_BODEGA = :idBodega");
            $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function listarResponsableBodega(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select p.nombre_persona from persona p");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idBodega){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, p.nombre_persona from bodega b inner join persona p on b.responsable_bodega = p.id_persona where b.nombre_bodega LIKE :patron");
            $stmt->bindValue(":patron", "%".$idBodega."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreBodega,$ubicacion,$nombreResponsable){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select ID_PERSONA FROM persona where NOMBRE_PERSONA = :nombreResponsable");
            $stmt->bindValue(":nombreResponsable", $nombreResponsable, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPersona = $results['ID_PERSONA'];

            $stmt = $conexion->prepare("INSERT INTO `bodega` (`NOMBRE_BODEGA`,`UBICACION`,`RESPONSABLE_BODEGA`) VALUES (:nombreBodega, :ubicacion, :responsableBodegaId);");
            $stmt->bindValue(":nombreBodega",$nombreBodega, PDO::PARAM_STR);
            $stmt->bindValue(":ubicacion",$ubicacion, PDO::PARAM_STR);
            $stmt->bindValue(":responsableBodegaId",$idPersona, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Modificar($idBodega,$nombreBodega,$ubicacion,$nombreResponsable){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select ID_PERSONA FROM persona where NOMBRE_PERSONA = :nombreResponsable");
            $stmt->bindValue(":nombreResponsable", $nombreResponsable, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPersona = $results['ID_PERSONA'];  
            
            $stmt = $conexion->prepare("UPDATE `bodega` 
                                        SET `NOMBRE_BODEGA` = :nombreBodega,
                                        `UBICACION` = :ubicacion,
                                        `RESPONSABLE_BODEGA` = :responsableBodegaId
                                        WHERE `ID_BODEGA` = :idBodega;");
            $stmt->bindValue(":nombreBodega",$nombreBodega, PDO::PARAM_STR);
            $stmt->bindValue(":ubicacion",$ubicacion, PDO::PARAM_STR);
            $stmt->bindValue(":responsableBodegaId",$idPersona, PDO::PARAM_INT);
            $stmt->bindValue(":idBodega",$idBodega,PDO::PARAM_INT); 
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información $idPersona";
            }
        }

        public function Eliminar($idBodega){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM bodega WHERE ID_BODEGA = :idBodega");
            $stmt->bindValue(":idBodega",$idBodega, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }
    }


?>