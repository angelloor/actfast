<?php

    require 'conexion.php';

    class reporteActivo{
        public function cagarValor($campo){
            $conexion = new Conexion();
            if($campo == "categoria"){
                $stmt = $conexion->prepare("select nombre_categoria as nombre from categoria");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if($campo == "marca"){
                $stmt = $conexion->prepare("select nombre_marca as nombre from marca");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if($campo == "estado"){
                $stmt = $conexion->prepare("select nombre_estado as nombre from estado");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if($campo == "funcionario"){
                $stmt = $conexion->prepare("select nombre_persona as nombre from persona;");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        public function consultar($campo,$valor){
            $conexion = new Conexion();
            if($campo == "categoria"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where ca.nombre_categoria = :valor;");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            if($campo == "marca"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where m.nombre_marca = :valor;");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            if($campo == "estado"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where e.nombre_estado = :valor;");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            if($campo == "funcionario"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join persona p on er.persona_id = p.id_persona where p.nombre_persona = :valor;");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        }
        
        public function cargarValor(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_categoria as nombre from categoria");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>