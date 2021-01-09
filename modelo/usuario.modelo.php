<?php

    require 'conexion.php';

    class Usuario{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select u.id_usuario, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario from usuario as u inner join persona as p on u.persona_id = p.id_persona inner join rol_usuario as ru on u.rol_usuario_id = ru.id_rol_usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idUsuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select u.id_usuario, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario from usuario as u inner join persona as p on u.persona_id = p.id_persona inner join rol_usuario as ru on u.rol_usuario_id = ru.id_rol_usuario and id_usuario = :idUsuario");
            $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idUsuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select u.id_usuario, p.nombre_persona, u.nombre_usuario, u.clave, ru.nombre_rol_usuario from usuario u inner join persona p on u.persona_id = p.id_persona inner join rol_usuario ru on u.rol_usuario_id = ru.id_rol_usuario where p.nombre_persona like :patron ");
            $stmt->bindValue(":patron", "%".$idUsuario."%", PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Guardar($personaId, $nombre, $clave, $rol_usuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select ID_PERSONA FROM persona where NOMBRE_PERSONA = :personaId");
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idp = $results['ID_PERSONA'];

            $stmt = $conexion->prepare("select ID_ROL_USUARIO from ROL_USUARIO where NOMBRE_ROL_USUARIO = :rol");
            $stmt->bindValue(":rol", $rol_usuario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idr = $results['ID_ROL_USUARIO'];
                
            //$claveMd5 = md5($clave);
            $stmt = $conexion->prepare("INSERT INTO `usuario`
                                                    (`PERSONA_ID`,
                                                    `NOMBRE_USUARIO`,
                                                    `CLAVE`,
                                                    `ROL_USUARIO_ID`)
                                        VALUES (:personaId,
                                                :nombre,
                                                :claveMd5,
                                                :rol_usuario_id);");
            $stmt->bindValue(":personaId", $idp, PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindValue(":claveMd5", $clave, PDO::PARAM_STR);
            $stmt->bindValue(":rol_usuario_id", $idr, PDO::PARAM_INT);
            if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
            
        public function Modificar($idUsuario, $personaId, $nombre, $clave, $rol_usuario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select ID_PERSONA FROM persona where NOMBRE_PERSONA = :personaId");
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idp = $results['ID_PERSONA'];

            $stmt = $conexion->prepare("select ID_ROL_USUARIO from ROL_USUARIO where NOMBRE_ROL_USUARIO = :rol");
            $stmt->bindValue(":rol", $rol_usuario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idr = $results['ID_ROL_USUARIO'];
            
            //$claveMd5 = md5($clave);
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE `usuario`
                                            SET `PERSONA_ID` = :personaId,
                                            `NOMBRE_USUARIO` = :nombre,
                                            `CLAVE` = :claveMd5,
                                            `ROL_USUARIO_ID` = :rol_usuario_id
                                            WHERE `ID_USUARIO` = :idUsuario;");
            $stmt->bindValue(":personaId", $idp, PDO::PARAM_INT);
            $stmt->bindValue(":nombre", $nombre, PDO::PARAM_STR);
            $stmt->bindValue(":claveMd5", $clave, PDO::PARAM_STR);
            $stmt->bindValue(":rol_usuario_id", $idr, PDO::PARAM_INT);
            $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }
        }

        public function Eliminar($idUsuario){
            $conexion = new Conexion();
            
            $stmt = $conexion->prepare("select count(*) from usuario");
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalUsuarios = $results['count(*)'];
            
            if($totalUsuarios == 1){
                return "No puede eliminar todos los usuarios";
            }else {
                $stmtdel = $conexion->prepare("DELETE FROM usuario WHERE ID_USUARIO = :idUsuario");
                $stmtdel->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
                if($stmtdel->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al eliminar el registro";
                }
            }
        }

        public function listarFuncionarios(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_PERSONA FROM persona order by nombre_persona asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarRoles(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_ROL_USUARIO FROM rol_usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>