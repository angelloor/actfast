<?php
    require 'conexion.php';

    class activosNoConfirmados{
        
        public function consultar(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where a.comprobacion_inventario = 'NO' order by a.codigo asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>