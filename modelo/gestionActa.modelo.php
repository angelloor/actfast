<?php

    require 'conexion.php';

    class gestionActa{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select er.id_entrega_recepcion, p.nombre_persona as funcionario, a.codigo, pe.nombre_persona as custodio, er.fecha from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo inner join custodio cu on er.custodio_id = cu.id_custodio inner join persona pe on cu.persona_id = pe.id_persona where a.historico = 1 order by a.codigo asc limit 50");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idgestionActa){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select er.id_entrega_recepcion, p.nombre_persona as funcionario, a.codigo, pe.nombre_persona as custodio, er.fecha from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo inner join custodio cu on er.custodio_id = cu.id_custodio inner join persona pe on cu.persona_id = pe.id_persona where er.id_entrega_recepcion = :idEntregaRecepcion");
            $stmt->bindValue(":idEntregaRecepcion", $idgestionActa, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idGestionActa,$campoBuscar){
            $conexion = new Conexion();

            if($campoBuscar == "Funcionario"){
                $stmt = $conexion->prepare("select er.id_entrega_recepcion, p.nombre_persona as funcionario, a.codigo, pe.nombre_persona as custodio, er.fecha from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo inner join custodio cu on er.custodio_id = cu.id_custodio inner join persona pe on cu.persona_id = pe.id_persona where (p.nombre_persona like :patron) and (historico = 1) order by a.codigo asc");
                $stmt->bindValue(":patron", "%".$idGestionActa."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Activo"){
                $stmt = $conexion->prepare("select er.id_entrega_recepcion, p.nombre_persona as funcionario, a.codigo, pe.nombre_persona as custodio, er.fecha from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona inner join activo a on er.activo_id = a.id_activo inner join custodio cu on er.custodio_id = cu.id_custodio inner join persona pe on cu.persona_id = pe.id_persona where (a.codigo like :patron) and (a.historico = 1) order by a.codigo asc");
                $stmt->bindValue(":patron", "%".$idGestionActa."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }

        public function Guardar($nombreFuncionario, $codigoActivo, $nombreCustodio, $fecha){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from activo where codigo = :codigo");
            $stmt->bindValue(":codigo", $codigoActivo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeActivo = $results['count(*)'];

            if($existeActivo == 0){
                return "El Activo no se encuentra registrado";
            }

            $stmt = $conexion->prepare("select count(*) from activo where (codigo = :codigo) and (historico = 0)");
            $stmt->bindValue(":codigo", $codigoActivo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $historicoActivo = $results['count(*)'];
            if($historicoActivo == 1){
                return "El Activo se encuentra dado de baja";
            }
            
            $stmt = $conexion->prepare("select count(*) from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo where a.codigo = :codigo;");
            $stmt->bindValue(":codigo", $codigoActivo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeActa = $results['count(*)'];

            if($existeActa >= 1){
                return "El activo ya se encuentra asignado a un funcionario";
            }
            
            $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :nombreFuncionario");
            $stmt->bindValue(":nombreFuncionario", $nombreFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPersona = $results['id_persona'];
       
            $stmt = $conexion->prepare("select id_activo from activo where codigo = :codigoActivo");
            $stmt->bindValue(":codigoActivo", $codigoActivo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idActivo = $results['id_activo'];

            $stmt = $conexion->prepare("select cu.id_custodio from custodio cu inner join persona p on cu.persona_id = p.id_persona where p.nombre_persona = :nombreCustodio");
            $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCustodio = $results['id_custodio'];
                
            $stmt = $conexion->prepare("insert into `entrega_recepcion`
                                                    (`persona_id`,
                                                    `activo_id`,
                                                    `custodio_id`,
                                                    `fecha`)
                                        values (:idPersona,
                                                :idActivo,
                                                :idCustodio,    
                                                :fecha);");
            $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
            $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
            $stmt->bindValue(":idCustodio", $idCustodio, PDO::PARAM_INT);
            $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
            if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
            
        public function Modificar($idActa, $nombreFuncionario, $codigoActivo, $nombreCustodio, $fecha){
            $conexion = new Conexion();

            $fechaTotal = getdate();
            $diaInicial = $fechaTotal['mday'];
            $mesInicial = $fechaTotal['mon'];
            $año = $fechaTotal['year'];
            if($diaInicial <= 9){
                $dia = "0".$diaInicial;
            }else{
                $dia = $diaInicial;
            }
            if($mesInicial <= 9){
                $mes = "0".$mesInicial;
            }else{
                $mes = $mesInicial;
            }
            $fechaActual = $año."-".$mes."-".$dia;

            $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :nombreFuncionario");
            $stmt->bindValue(":nombreFuncionario", $nombreFuncionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPersona = $results['id_persona'];
       
            $stmt = $conexion->prepare("select id_activo from activo where codigo = :codigoActivo");
            $stmt->bindValue(":codigoActivo", $codigoActivo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idActivo = $results['id_activo'];

            $stmt = $conexion->prepare("select cu.id_custodio from custodio cu inner join persona p on cu.persona_id = p.id_persona where p.nombre_persona = :nombreCustodio");
            $stmt->bindValue(":nombreCustodio", $nombreCustodio, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCustodio = $results['id_custodio'];
                
            $stmt = $conexion->prepare("update `entrega_recepcion`
                                            set `persona_id` = :idPersona,
                                            `activo_id` = :idActivo,
                                            `custodio_id` = :idCustodio,
                                            `fecha` = :fecha
                                            where `id_entrega_recepcion` = :idActa;");
            $stmt->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
            $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
            $stmt->bindValue(":idCustodio", $idCustodio, PDO::PARAM_INT);
            $stmt->bindValue(":fecha", $fecha, PDO::PARAM_STR);
            $stmt->bindValue(":idActa", $idActa, PDO::PARAM_INT);

            $stmt1 = $conexion->prepare("insert into `movimiento_activo`
                                                    (`activo_id`,
                                                    `custodio_id`,
                                                    `persona_id`,
                                                    `fecha_movimiento`)
                                        values (:idActivo,
                                                :idCustodio,
                                                :idPersona,    
                                                :fecha);");
            $stmt1->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
            $stmt1->bindValue(":idCustodio", $idCustodio, PDO::PARAM_INT);
            $stmt1->bindValue(":idPersona", $idPersona, PDO::PARAM_INT);
            $stmt1->bindValue(":fecha", $fechaActual, PDO::PARAM_STR);
            if(($stmt->execute()) && ($stmt1->execute())){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }
        }

        public function Eliminar($idEntregaRecepcion){
            $conexion = new Conexion();
            $stmtdel = $conexion->prepare("delete from entrega_recepcion where id_entrega_recepcion = :idEntregaRecepcion");
            $stmtdel->bindValue(":idEntregaRecepcion", $idEntregaRecepcion, PDO::PARAM_INT);
            if($stmtdel->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function listarFuncionario(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_persona from persona order by nombre_persona asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarActivo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.codigo activo from activo a where a.historico = 1 order by a.codigo asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarCustodio(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select p.nombre_persona from custodio cu inner join persona p on cu.persona_id = p.id_persona order by p.nombre_persona asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>