<?php
    require 'conexion.php';

    class Estado{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select id_estado, nombre_estado from estado");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select id_estado, nombre_estado from estado where id_estado = :idEstado");
            $stmt->bindValue(":idEstado", $idEstado, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select id_estado, nombre_estado from estado where nombre_estado like :patron");
            $stmt->bindValue(":patron", "%".$idEstado."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from estado where nombre_estado = :nombreEstado;");
            $stmt->bindValue(":nombreEstado", $nombreEstado, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "El estado ya existe";
            }else{
                $stmt = $conexion->prepare("insert into `estado` (`nombre_estado`) 
                                values (:nombreEstado);");
                $stmt->bindValue(":nombreEstado",$nombreEstado, PDO::PARAM_STR);
                if($stmt->execute()){
                return "OK";
                }else{
                return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idEstado,$nombreEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from estado where nombre_estado = :nombreEstado;");
            $stmt->bindValue(":nombreEstado", $nombreEstado, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            $stmt = $conexion->prepare("select nombre_estado from estado where id_estado = :idEstado;");
            $stmt->bindValue(":idEstado", $idEstado, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $estadoBD = $results['nombre_estado'];

            if ($nombreEstado == $estadoBD) {
                $stmt = $conexion->prepare("update `estado` 
                                set `nombre_estado` = :nombreEstado
                                where `id_estado` = :idEstado;");
                $stmt->bindValue(":nombreEstado",$nombreEstado,PDO::PARAM_STR); 
                $stmt->bindValue(":idEstado",$idEstado,PDO::PARAM_INT); 
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al modificar la información";
                }
            }else{
                if($existeRegistro >= 1){
                    return "El estado ya existe";
                }else{
                    $stmt = $conexion->prepare("update `estado` 
                                                set `nombre_estado` = :nombreEstado
                                                where `id_estado` = :idEstado;");
                    $stmt->bindValue(":nombreEstado",$nombreEstado,PDO::PARAM_STR); 
                    $stmt->bindValue(":idEstado",$idEstado,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        }

        public function Eliminar($idEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("delete from estado where id_estado = :idEstado");
            $stmt->bindValue(":idEstado",$idEstado, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function consultarRegistros($idEstado){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) as registros from activo where estado_id = :idEstado;");
            $stmt->bindValue(":idEstado",$idEstado, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>