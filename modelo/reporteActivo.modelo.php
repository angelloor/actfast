<?php

    require 'conexion.php';

    class reporteActivo{
        public function listarCategoria(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_CATEGORIA FROM CATEGORIA");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarMarca(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_MARCA FROM MARCA");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarEstado(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_ESTADO FROM ESTADO");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarCustodio(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarFuncionario(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_persona from persona");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }
?>