<?php

    require 'conexion.php';

    class movimientoActivo{

        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select ma.id_movimiento_activo, a.codigo as codigo, p.nombre_persona as nombreCustodio, pe.nombre_persona as nombreFuncionario, ma.fecha_movimiento from movimiento_activo ma inner join activo a on ma.activo_id = a.id_activo inner join custodio cu on ma.custodio_id = cu.id_custodio inner join persona p on cu.persona_id = p.id_persona inner join persona pe on ma.persona_id = pe.id_persona;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorFecha($fechaInicio,$fechaFinal){
            $conexion =  new Conexion();
            $stmt = $conexion->prepare("select ma.id_movimiento_activo, a.codigo as codigo, p.nombre_persona as nombreCustodio, pe.nombre_persona as nombreFuncionario, ma.fecha_movimiento from movimiento_activo ma inner join activo a on ma.activo_id = a.id_activo inner join custodio cu on ma.custodio_id = cu.id_custodio inner join persona p on cu.persona_id = p.id_persona inner join persona pe on ma.persona_id = pe.id_persona where ma.fecha_movimiento between :fechaInicio and :fechaFinal;");
            $stmt->bindValue(":fechaInicio",$fechaInicio, PDO::PARAM_STR);
            $stmt->bindValue(":fechaFinal",$fechaFinal, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>