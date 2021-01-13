<?php

    require 'conexion.php';

    class comprobacionInventario{

        public function Consultar($codigoActivo){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.id_activo, a.codigo, e.nombre_estado, p.nombre_persona as funcionario, a.comentario from activo a inner join estado e on a.estado_id = e.id_estado inner join entrega_recepcion er on er.activo_id = a.id_activo inner join persona p on er.persona_id = p.id_persona where a.codigo = :codigoActivo");
            $stmt->bindValue(":codigoActivo", $codigoActivo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }
        
        public function listarFuncionario(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_persona from persona");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarEstado(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_estado from estado");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Restablecer(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("update activo set comprobacion_inventario = 'NO'");
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al restablecer la comprobación de inventario";
            }
        }
        
        public function Guardar($codigo,$estado,$funcionario,$comentario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select comprobacion_inventario from activo where codigo = :codigo;");
            $stmt->bindValue(":codigo", $codigo, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $estadoActivo = $results['comprobacion_inventario'];

            if ($estadoActivo == "SI") {
                return "El activo ya se encuentra verificado";
            }else{
                $stmt = $conexion->prepare("select id_activo from activo where codigo = :codigoActivo");
                $stmt->bindValue(":codigoActivo", $codigo, PDO::PARAM_INT);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idActivo = $results['id_activo'];

                $stmt = $conexion->prepare("select id_estado from estado where nombre_estado = :estado");
                $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idEstado = $results['id_estado'];

                $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :nombrePersona");
                $stmt->bindValue(":nombrePersona", $funcionario, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idPersona = $results['id_persona'];
                
                $comprobacionInventario = "SI";

                // Actualizamos la persona a cargo del activo
                $stmtone = $conexion->prepare("update `entrega_recepcion` 
                                            set `persona_id` = :idPersona
                                            where `activo_id` = :idActivo;");
                $stmtone->bindValue(":idPersona",$idPersona,PDO::PARAM_INT); 
                $stmtone->bindValue(":idActivo",$idActivo,PDO::PARAM_INT); 
                $stmtone->execute();
                // Actualizamos los datos de la comprobacion del inventario 
                $stmttwo = $conexion->prepare("update `activo`
                                            set `estado_id` = :idEstado,
                                            `comentario` = :comentario,
                                            `comprobacion_inventario` = :comprobacionInventario
                                            where `id_activo` = :idActivo;");
                $stmttwo->bindValue(":idEstado",$idEstado,PDO::PARAM_INT); 
                $stmttwo->bindValue(":comentario",$comentario,PDO::PARAM_STR); 
                $stmttwo->bindValue(":comprobacionInventario",$comprobacionInventario,PDO::PARAM_STR); 
                $stmttwo->bindValue(":idActivo",$idActivo,PDO::PARAM_INT); 
                $stmttwo->execute();

                if($stmttwo->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al modificar la información";
                }
            }
        }
    }
?>