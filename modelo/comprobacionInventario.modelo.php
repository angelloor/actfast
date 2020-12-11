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
            $stmt = $conexion->prepare("SELECT NOMBRE_PERSONA FROM persona");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarEstado(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_ESTADO FROM ESTADO");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function Restablecer(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE activo SET comprobacion_inventario = 'NO'");
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al restablecer la comprobación de inventario";
            }

        }
        public function Guardar($codigo,$estado,$funcionario,$comentario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select id_activo from activo where codigo = :codigoActivo");
            $stmt->bindValue(":codigoActivo", $codigo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idActivo = $results['id_activo'];

            $stmt = $conexion->prepare("select ID_ESTADO from estado where NOMBRE_ESTADO = :estado");
            $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idEstado = $results['ID_ESTADO'];
      

            $stmt = $conexion->prepare("select ID_PERSONA from persona where NOMBRE_PERSONA = :nombrePersona");
            $stmt->bindValue(":nombrePersona", $funcionario, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idPersona = $results['ID_PERSONA'];
             
            $comprobacionInventario = "SI";

            // Actualizamos la persona a cargo del activo
            $stmtone = $conexion->prepare("UPDATE `entrega_recepcion` 
                                        SET `PERSONA_ID` = :idPersona
                                        WHERE `ACTIVO_ID` = :idActivo;");
            $stmtone->bindValue(":idPersona",$idPersona,PDO::PARAM_INT); 
            $stmtone->bindValue(":idActivo",$idActivo,PDO::PARAM_INT); 
            $stmtone->execute();
            // Actualizamos los datos de la comprobacion del inventario 
            $stmttwo = $conexion->prepare("UPDATE `activo`
                                        SET `ESTADO_ID` = :idEstado,
                                        `COMENTARIO` = :comentario,
                                        `COMPROBACION_INVENTARIO` = :comprobacionInventario
                                        WHERE `ID_ACTIVO` = :idActivo;");
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

            // $cadena = "Codigo " . $codigo . "Estado " . $estado . "Funcionario " . $funcionario . "Comentario" . $comentario . " idActivo" .$idActivo . " idEstado" .$idEstado . " idPersona" .$idPersona;
            // return $cadena;
        }
    }
?>