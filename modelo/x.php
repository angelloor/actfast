<?php

require 'conexion.php';
$conexion = new Conexion();


$stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado;");
$stmt->execute();
$datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

PRINT <<<HERE
    <br>
    HERE;
foreach ($datos as $row) {
    echo $row['codigo'];
    echo $row['nombre_activo'];
    echo $row['caracteristica'];
    echo $row['nombre_marca'];
    echo $row['modelo'];
    echo $row['serie'];    
    echo $row['nombre_estado'];
    PRINT <<<HERE
    <br>
    HERE;
}

?>