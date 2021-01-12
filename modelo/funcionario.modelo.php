<?php
    require 'conexion.php';

    class Funcionario{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select p.id_persona, p.cedula, p.nombre_persona, p.direccion, p.telefono, c.nombre_cargo, u.nombre_unidad from persona p inner join cargo c on p.cargo_id = c.id_cargo inner join unidad u on p.unidad_id = u.id_unidad order by p.nombre_persona asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idFuncionario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT P.ID_PERSONA, P.CEDULA, P.NOMBRE_PERSONA, P.DIRECCION, P.TELEFONO, C.NOMBRE_CARGO, U.NOMBRE_UNIDAD FROM PERSONA P INNER JOIN CARGO C ON P.CARGO_ID = C.ID_CARGO INNER JOIN UNIDAD U ON P.UNIDAD_ID = U.ID_UNIDAD WHERE ID_PERSONA = :idFuncionario");
            $stmt->bindValue(":idFuncionario", $idFuncionario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idFuncionario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT P.ID_PERSONA, P.CEDULA, P.NOMBRE_PERSONA, P.DIRECCION, P.TELEFONO, C.NOMBRE_CARGO, U.NOMBRE_UNIDAD FROM PERSONA P INNER JOIN CARGO C ON P.CARGO_ID = C.ID_CARGO INNER JOIN UNIDAD U ON P.UNIDAD_ID = U.ID_UNIDAD WHERE P.NOMBRE_PERSONA LIKE :patron order by p.nombre_persona asc");
            $stmt->bindValue(":patron", "%".$idFuncionario."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        public function Guardar($cedulaFuncionario,$nombreFuncionario,$direccionFuncionario,$telefonoFuncionario,$cargoFuncionario,$unidadFuncionario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT ID_CARGO FROM CARGO WHERE NOMBRE_CARGO = :cargoFuncionario");
            $stmt->bindValue(":cargoFuncionario", $cargoFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCargo = $results['ID_CARGO'];

            $stmt = $conexion->prepare("select count(*) from persona where cedula = :cedulaFuncionario");
            $stmt->bindValue(":cedulaFuncionario", $cedulaFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro >= 1){
                return "El Funcionario ya existe ";
            }else{
                $stmt = $conexion->prepare("SELECT ID_UNIDAD FROM UNIDAD WHERE NOMBRE_UNIDAD = :unidadFuncionario");
                $stmt->bindValue(":unidadFuncionario", $unidadFuncionario, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idUnidad = $results['ID_UNIDAD'];
                
                $stmt = $conexion->prepare("INSERT INTO `persona` (`CEDULA`,`NOMBRE_PERSONA`,`DIRECCION`,`TELEFONO`,`CARGO_ID`,`UNIDAD_ID`) 
                                            VALUES (:cedulaFuncionario, :nombreFuncionario, :direccionFuncionario, :telefonoFuncionario, :cargoFuncionario, :unidadFuncionario);");
                $stmt->bindValue(":cedulaFuncionario",$cedulaFuncionario, PDO::PARAM_INT);
                $stmt->bindValue(":nombreFuncionario",$nombreFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":direccionFuncionario",$direccionFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":telefonoFuncionario",$telefonoFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":cargoFuncionario",$idCargo, PDO::PARAM_INT);
                $stmt->bindValue(":unidadFuncionario",$idUnidad, PDO::PARAM_INT);
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idFuncionario,$cedulaFuncionario,$nombreFuncionario,$direccionFuncionario,$telefonoFuncionario,$cargoFuncionario,$unidadFuncionario){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from persona where cedula = :cedulaFuncionario");
            $stmt->bindValue(":cedulaFuncionario", $cedulaFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];

            if($existeRegistro >= 1){
                return "El numero de cedula ya esta asignado a un funcionario";
            }else{
                $stmt = $conexion->prepare("SELECT ID_CARGO FROM CARGO WHERE NOMBRE_CARGO = :cargoFuncionario");
                $stmt->bindValue(":cargoFuncionario", $cargoFuncionario, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idCargo = $results['ID_CARGO'];

                $stmt = $conexion->prepare("SELECT ID_UNIDAD FROM UNIDAD WHERE NOMBRE_UNIDAD = :unidadFuncionario");
                $stmt->bindValue(":unidadFuncionario", $unidadFuncionario, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idUnidad = $results['ID_UNIDAD'];
            
                $stmt = $conexion->prepare("UPDATE `persona` 
                                            SET `CEDULA` = :cedulaFuncionario, 
                                            `NOMBRE_PERSONA` = :nombreFuncionario,
                                            `DIRECCION` = :direccionFuncionario,
                                            `TELEFONO` = :telefonoFuncionario,
                                            `CARGO_ID` = :cargoFuncionario,
                                            `UNIDAD_ID` = :unidadFuncionario
                                            WHERE `ID_PERSONA` = :idFuncionario;");
                $stmt->bindValue(":cedulaFuncionario",$cedulaFuncionario, PDO::PARAM_INT);
                $stmt->bindValue(":nombreFuncionario",$nombreFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":direccionFuncionario",$direccionFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":telefonoFuncionario",$telefonoFuncionario, PDO::PARAM_STR);
                $stmt->bindValue(":cargoFuncionario",$idCargo, PDO::PARAM_INT);
                $stmt->bindValue(":unidadFuncionario",$idUnidad, PDO::PARAM_INT);
                $stmt->bindValue(":idFuncionario",$idFuncionario,PDO::PARAM_INT); 
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al modificar la información";
                }
            }
        }

        public function Eliminar($idFuncionario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("DELETE FROM persona WHERE ID_PERSONA  = :idFuncionario");
            $stmt->bindValue(":idFuncionario",$idFuncionario, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function listarCargo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_CARGO FROM CARGO order by NOMBRE_CARGO asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarUnidad(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_UNIDAD FROM UNIDAD order by NOMBRE_UNIDAD asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>