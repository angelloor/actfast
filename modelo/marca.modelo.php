<?php
    require 'conexion.php';

    class Marca{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select id_marca, nombre_marca from marca");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select id_marca, nombre_marca from marca where id_marca = :idMarca");
            $stmt->bindValue(":idMarca", $idMarca, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select id_marca, nombre_marca from marca where nombre_marca like :patron");
            $stmt->bindValue(":patron", "%".$idMarca."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from marca where nombre_marca = :nombreMarca;");
            $stmt->bindValue(":nombreMarca", $nombreMarca, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "La marca ya existe";
            }else{
                $stmt = $conexion->prepare("insert into `marca` (`nombre_marca`) 
                                            values (:nombreMarca);");
                $stmt->bindValue(":nombreMarca",$nombreMarca, PDO::PARAM_STR);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idMarca,$nombreMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from marca where nombre_marca = :nombreMarca;");
            $stmt->bindValue(":nombreMarca", $nombreMarca, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            $stmt = $conexion->prepare("select nombre_marca from marca where id_marca = :idMarca;");
            $stmt->bindValue(":idMarca", $idMarca, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $marcaBD = $results['nombre_marca'];

            if ($nombreMarca == $marcaBD) {
                $stmt = $conexion->prepare("update `marca` 
                                            set `nombre_marca` = :nombreMarca
                                            where `id_marca` = :idMarca;");
                $stmt->bindValue(":nombreMarca",$nombreMarca,PDO::PARAM_STR); 
                $stmt->bindValue(":idMarca",$idMarca,PDO::PARAM_INT); 
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }else{
                if($existeRegistro >= 1){
                    return "La marca ya existe";
                }else{
                    $stmt = $conexion->prepare("update `marca` 
                                                set `nombre_marca` = :nombreMarca
                                                where `id_marca` = :idMarca;");
                    $stmt->bindValue(":nombreMarca",$nombreMarca,PDO::PARAM_STR); 
                    $stmt->bindValue(":idMarca",$idMarca,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al guardar la información";
                    }
                }
            }
        }

        public function Eliminar($idMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("delete from marca where id_marca = :idMarca");
            $stmt->bindValue(":idMarca",$idMarca, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function consultarRegistros($idMarca){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) as registros from activo where marca_id = :idMarca;");
            $stmt->bindValue(":idMarca",$idMarca, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
    }
?>