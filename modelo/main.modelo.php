<?php
    require 'conexion.php';

    class Main{
        public function cargarCategoria(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_CATEGORIA FROM CATEGORIA");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>