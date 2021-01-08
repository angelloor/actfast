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
        public function listarFuncionario(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_PERSONA FROM persona order by NOMBRE_PERSONA asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarActivo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.codigo activo from activo a where a.historico = 1 order by a.codigo asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>