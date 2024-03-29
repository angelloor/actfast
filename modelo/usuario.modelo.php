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
            $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :personaId");
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idp = $results['id_persona'];

            $stmt = $conexion->prepare("select id_rol_usuario from rol_usuario where nombre_rol_usuario = :rol");
            $stmt->bindValue(":rol", $rol_usuario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idr = $results['id_rol_usuario'];
            
            //            
            $stmt = $conexion->prepare("select count(*) from usuario where nombre_usuario = :nombreUsuario;");  
            $stmt->bindValue(":nombreUsuario", $nombre, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeUsuario = $results['count(*)'];

            if($existeUsuario >= 1 ){
                return "el nombre de usuario ya existe";
            }

            if($rol_usuario == "ADMINISTRADOR") {
                return "Solo pueda haber un Administrador";
            }else{
                //$claveMd5 = md5($clave);
                $stmt = $conexion->prepare("insert into `usuario`
                                                        (`persona_id`,
                                                        `nombre_usuario`,
                                                        `clave`,
                                                        `rol_usuario_id`)
                                            values (:personaId,
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
            }
            
        public function Modificar($idUsuario, $personaId, $nombre, $clave, $rol_usuario){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from usuario where nombre_usuario = :nombreUsuario;");
            $stmt->bindValue(":nombreUsuario", $nombre, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeUsuario = $results['count(*)'];

            $stmt = $conexion->prepare("select nombre_usuario from usuario where id_usuario = :idUsuario;");
            $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $nombreUsuarioBD = $results['nombre_usuario'];

            $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :personaId");
            $stmt->bindValue(":personaId", $personaId, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idp = $results['id_persona'];

            $stmt = $conexion->prepare("select id_rol_usuario from rol_usuario where nombre_rol_usuario = :rol");
            $stmt->bindValue(":rol", $rol_usuario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idr = $results['id_rol_usuario'];
            
            if ($nombre == $nombreUsuarioBD) {
                if($idUsuario == 1){
                    //$claveMd5 = md5($clave);
                    $stmt = $conexion->prepare("update `usuario`
                                set `persona_id` = :personaId,
                                `nombre_usuario` = :nombre,
                                `clave` = :claveMd5,
                                `rol_usuario_id` = :rol_usuario_id
                                where `id_usuario` = :idUsuario;");
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
                }else{
                    if($rol_usuario == "ADMINISTRADOR") {
                        return "Solo pueda haber un Administrador";
                    }else{
                        //$claveMd5 = md5($clave);
                        $stmt = $conexion->prepare("update `usuario`
                                    set `persona_id` = :personaId,
                                    `nombre_usuario` = :nombre,
                                    `clave` = :claveMd5,
                                    `rol_usuario_id` = :rol_usuario_id
                                    where `id_usuario` = :idUsuario;");
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
                }
            }else{
                if($existeUsuario >= 1){
                    return "el nombre de usuario ya existe";
                }else{
                    if($idUsuario == 1){
                        //$claveMd5 = md5($clave);
                        $stmt = $conexion->prepare("update `usuario`
                                    set `persona_id` = :personaId,
                                    `nombre_usuario` = :nombre,
                                    `clave` = :claveMd5,
                                    `rol_usuario_id` = :rol_usuario_id
                                    where `id_usuario` = :idUsuario;");
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
                    }else{
                        if($rol_usuario == "ADMINISTRADOR") {
                            return "Solo pueda haber un Administrador";
                        }else{
                            //$claveMd5 = md5($clave);
                            $stmt = $conexion->prepare("update `usuario`
                                        set `persona_id` = :personaId,
                                        `nombre_usuario` = :nombre,
                                        `clave` = :claveMd5,
                                        `rol_usuario_id` = :rol_usuario_id
                                        where `id_usuario` = :idUsuario;");
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
                    }
                }
            }
        }

        public function Eliminar($idUsuario){
            $conexion = new Conexion();
            
            $stmt = $conexion->prepare("select count(*) from usuario");
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $totalUsuarios = $results['count(*)'];
            
            $stmt = $conexion->prepare("select ru.nombre_rol_usuario from usuario u inner join rol_usuario ru on u.rol_usuario_id = ru.id_rol_usuario where u.id_usuario = :idUsuario;");
            $stmt->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRolUsuario = $results['nombre_rol_usuario'];

            if($totalUsuarios == 1){
                return "No puede eliminar todos los usuarios";
            }else {
                if($existeRolUsuario == "ADMINISTRADOR"){
                    return "No puede eliminar al Administrador";
                }else{
                    $stmtdel = $conexion->prepare("delete from usuario where id_usuario = :idUsuario");
                    $stmtdel->bindValue(":idUsuario", $idUsuario, PDO::PARAM_INT);
                    if($stmtdel->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al eliminar el registro";
                    }
                }
            }
        }

        public function listarFuncionarios(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_persona from persona order by nombre_persona asc");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarRoles(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_rol_usuario from rol_usuario");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>