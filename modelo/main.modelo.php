<?php
    require 'conexion.php';

    class Main{
        
        public function cargarCategoria(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_CATEGORIA FROM CATEGORIA");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        public function listarCategoria(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_CATEGORIA FROM CATEGORIA order by nombre_categoria asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarActivo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.codigo activo from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo where a.historico = 1 order by a.codigo asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarFuncionarioPorCategoria($categoria){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select distinct p.nombre_persona from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join categoria ca on a.categoria_id = ca.id_categoria inner join persona p on er.persona_id = p.id_persona where ca.nombre_categoria = :nombreCategoria order by p.nombre_persona asc;");
            $stmt->bindValue(":nombreCategoria", $categoria, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>