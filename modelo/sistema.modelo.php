<?php
    require 'conexion.php';

    class Sistema{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select * from sistema");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idSistema){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM sistema where ID_sistema = :idSistema");
            $stmt->bindValue(":idSistema", $idSistema, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idSistema){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT * FROM sistema where nombre_sistema LIKE :patron");
            $stmt->bindValue(":patron", "%".$idSistema."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($nombreSistema,$direccion){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from sistema where nombre_sistema = :nombreSistema;");
            $stmt->bindValue(":nombreSistema", $nombreSistema, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "El sistema ya existe";
            }else{
                $stmt = $conexion->prepare("INSERT INTO `sistema` (`NOMBRE_SISTEMA`,`DIRECCION_SISTEMA`) 
                                VALUES (:nombreSistema,:direccionSistema);");
                $stmt->bindValue(":nombreSistema",$nombreSistema, PDO::PARAM_STR);
                $stmt->bindValue(":direccionSistema",$direccion, PDO::PARAM_STR);
                if($stmt->execute()){
                return "OK";
                }else{
                return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idSistema,$nombreSistema,$direccion){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from sistema where nombre_sistema = :nombreSistema;");
            $stmt->bindValue(":nombreSistema", $nombreSistema, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "El sistema ya existe";
            }else{
                $stmt = $conexion->prepare("UPDATE `sistema` 
                                SET `NOMBRE_SISTEMA` = :nombreSistema,
                                `DIRECCION_SISTEMA` = :direccionSistema
                                WHERE `ID_SISTEMA` = :idSistema;");
                $stmt->bindValue(":nombreSistema",$nombreSistema,PDO::PARAM_STR); 
                $stmt->bindValue(":idSistema",$idSistema,PDO::PARAM_INT); 
                $stmt->bindValue(":direccionSistema",$direccion, PDO::PARAM_STR);
                if($stmt->execute()){
                return "OK";
                }else{
                return "Error: se ha generado un error al modificar la información";
                }
            }
        }

        public function Eliminar($idSistema){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM sistema WHERE ID_sistema = :idSistema");
            $stmt->bindValue(":idSistema",$idSistema, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }
    }
?>