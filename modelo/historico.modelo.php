<?php
    require 'conexion.php';

    class historico{

        public function consultar(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, m.nombre_marca, a.serie, a.modelo, a.fecha_historico from activo a inner join marca m on a.marca_id = m.id_marca where a.historico = 0;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idActivo,$fechaHistorico){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("update `activo` set `historico` = 1, `fecha_historico` = :fechaHistorico  where id_activo = :idActivo");
            $stmt->bindValue(":idActivo",$idActivo, PDO::PARAM_INT);
            $stmt->bindValue(":fechaHistorico",$fechaHistorico, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al restablecer el activo el registro";
            }
        }

        public function ConsultarPorFecha($fechaInicio,$fechaFinal){
            $conexion =  new Conexion();
            $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, m.nombre_marca, a.serie, a.modelo, a.fecha_historico from activo a inner join marca m on a.marca_id = m.id_marca where (a.historico = 0) and (a.fecha_historico between :fechaInicio and :fechaFinal);");
            $stmt->bindValue(":fechaInicio",$fechaInicio, PDO::PARAM_STR);
            $stmt->bindValue(":fechaFinal",$fechaFinal, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>