<?php
    require 'conexion.php';

    class Bodega{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, p.nombre_persona from bodega b inner join persona p on b.responsable_bodega = p.id_persona order by b.id_bodega asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idBodega){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, p.nombre_persona from bodega b inner join persona p on b.responsable_bodega = p.id_persona where b.id_bodega = :idBodega");
            $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function listarResponsableBodega(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select p.nombre_persona from persona p order by p.nombre_persona asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idBodega){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select b.id_bodega, b.nombre_bodega, b.ubicacion, p.nombre_persona from bodega b inner join persona p on b.responsable_bodega = p.id_persona where b.nombre_bodega like :patron");
            $stmt->bindValue(":patron", "%".$idBodega."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreBodega,$ubicacion,$nombreResponsable){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from bodega where nombre_bodega = :nombreBodega;");
            $stmt->bindValue(":nombreBodega", $nombreBodega, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "La bodega ya existe";
            }else{
                $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :nombreResponsable");
                $stmt->bindValue(":nombreResponsable", $nombreResponsable, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idPersona = $results['id_persona'];

                $stmt = $conexion->prepare("insert into `bodega` (`nombre_bodega`,`ubicacion`,`responsable_bodega`) values (:nombreBodega, :ubicacion, :responsableBodegaId);");
                $stmt->bindValue(":nombreBodega",$nombreBodega, PDO::PARAM_STR);
                $stmt->bindValue(":ubicacion",$ubicacion, PDO::PARAM_STR);
                $stmt->bindValue(":responsableBodegaId",$idPersona, PDO::PARAM_INT);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idBodega,$nombreBodega,$ubicacion,$nombreResponsable){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from bodega where nombre_bodega = :nombreBodega;");
            $stmt->bindValue(":nombreBodega", $nombreBodega, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            $stmt = $conexion->prepare("select nombre_bodega from bodega where id_bodega = :idBodega;");
            $stmt->bindValue(":idBodega", $idBodega, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $bodegaBD = $results['nombre_bodega'];

            if ($nombreBodega == $bodegaBD) {
                $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :nombreResponsable");
                $stmt->bindValue(":nombreResponsable", $nombreResponsable, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idPersona = $results['id_persona'];  
                
                $stmt = $conexion->prepare("update `bodega` 
                                            set `nombre_bodega` = :nombreBodega,
                                            `ubicacion` = :ubicacion,
                                            `responsable_bodega` = :responsableBodegaId
                                            where `id_bodega` = :idBodega;");
                $stmt->bindValue(":nombreBodega",$nombreBodega, PDO::PARAM_STR);
                $stmt->bindValue(":ubicacion",$ubicacion, PDO::PARAM_STR);
                $stmt->bindValue(":responsableBodegaId",$idPersona, PDO::PARAM_INT);
                $stmt->bindValue(":idBodega",$idBodega,PDO::PARAM_INT); 
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al modificar la información $idPersona";
                }
            }else{
                if($existeRegistro >= 1){
                    return "La bodega ya existe";
                }else{
                    $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :nombreResponsable");
                    $stmt->bindValue(":nombreResponsable", $nombreResponsable, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idPersona = $results['id_persona'];  
                    
                    $stmt = $conexion->prepare("update `bodega` 
                                                set `nombre_bodega` = :nombreBodega,
                                                `ubicacion` = :ubicacion,
                                                `responsable_bodega` = :responsableBodegaId
                                                where `id_bodega` = :idBodega;");
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
            }
        }

        public function Eliminar($idBodega){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("delete from bodega where id_bodega = :idBodega");
            $stmt->bindValue(":idBodega",$idBodega, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function consultarRegistros($idBodega){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) as registros from activo where bodega_id = :idBodega;");
            $stmt->bindValue(":idBodega",$idBodega, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>