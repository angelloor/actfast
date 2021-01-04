<?php
    require 'conexion.php';

    class Sistema{
        public function cargarSistemas(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_sistema from sistema");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        
        public function listarFuncionario(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_PERSONA FROM persona");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
    }


?>