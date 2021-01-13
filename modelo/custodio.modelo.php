<?php
    require 'conexion.php';

    class Custodio{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select c.id_custodio, p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona order by id_custodio asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idCustodio){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select c.id_custodio, p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona where ID_CUSTODIO = :idCustodio");
            $stmt->bindValue(":idCustodio", $idCustodio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idCustodio){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select c.id_custodio, p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona where p.nombre_persona LIKE :patron");
            $stmt->bindValue(":patron", "%".$idCustodio."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarFuncionarios(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_PERSONA FROM persona");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($personaId){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from custodio cu inner join persona p on cu.persona_id = p.id_persona where p.nombre_persona = :personaId;");
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "El custodio ya existe";
            }else{
                $stmt = $conexion->prepare("select ID_PERSONA FROM persona where NOMBRE_PERSONA = :personaId");
                $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idp = $results['ID_PERSONA'];

                $stmt = $conexion->prepare("INSERT INTO `custodio` (`PERSONA_ID`) 
                                            VALUES (:nombreCustodio);");
                $stmt->bindValue(":nombreCustodio",$idp, PDO::PARAM_INT);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idCustodio,$nombreCustodio){

            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) from custodio cu inner join persona p on cu.persona_id = p.id_persona where p.nombre_persona = :nombreCustodio;");
            $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            $stmt = $conexion->prepare("select p.nombre_persona from custodio cu inner join persona p on cu.persona_id = p.id_persona where cu.id_custodio = :idCustodio;");
            $stmt->bindValue(":idCustodio", $idCustodio, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $custodioBD = $results['nombre_persona'];

            if ($nombreCustodio == $custodioBD) {
                $stmt = $conexion->prepare("select ID_PERSONA FROM persona where NOMBRE_PERSONA = :nombreCustodio");
                $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idp = $results['ID_PERSONA'];

                $stmt = $conexion->prepare("UPDATE `custodio` 
                                            SET `PERSONA_ID` = :idPersona
                                            WHERE `ID_CUSTODIO` = :idCustodio;");
                $stmt->bindValue(":idPersona",$idp,PDO::PARAM_INT); 
                $stmt->bindValue(":idCustodio",$idCustodio,PDO::PARAM_INT); 
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al modificar la información";
                }
            }else{
                if($existeRegistro >= 1){
                    return "El custodio ya existe";
                }else{
                    $stmt = $conexion->prepare("select ID_PERSONA FROM persona where NOMBRE_PERSONA = :nombreCustodio");
                    $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idp = $results['ID_PERSONA'];
    
                    $stmt = $conexion->prepare("UPDATE `custodio` 
                                                SET `PERSONA_ID` = :idPersona
                                                WHERE `ID_CUSTODIO` = :idCustodio;");
                    $stmt->bindValue(":idPersona",$idp,PDO::PARAM_INT); 
                    $stmt->bindValue(":idCustodio",$idCustodio,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        }

        public function Eliminar($idCustodio){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM custodio WHERE ID_CUSTODIO = :idCustodio");
            $stmt->bindValue(":idCustodio",$idCustodio, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function consultarRegistros($idCustodio){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) as registros from entrega_recepcion where custodio_id = :idCustodio;");
            $stmt->bindValue(":idCustodio",$idCustodio, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>