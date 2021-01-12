<?php

    require 'conexion.php';

    class reporteActivo{
        
        public function cargaInicial(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria order by codigo asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        public function cagarValor($campo){
            $conexion = new Conexion();
            if($campo == "categoria"){
                $stmt = $conexion->prepare("select nombre_categoria as nombre from categoria order by nombre_categoria asc;");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if($campo == "marca"){
                $stmt = $conexion->prepare("select nombre_marca as nombre from marca order by nombre_marca asc;");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if($campo == "estado"){
                $stmt = $conexion->prepare("select nombre_estado as nombre from estado order by nombre_estado asc;");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }

            if($campo == "funcionario"){
                $stmt = $conexion->prepare("select nombre_persona as nombre from persona order by nombre_persona asc;");
                $stmt->bindValue(":campo", $campo, PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        public function consultar($campo,$valor){
            $conexion = new Conexion();
            if($campo == "categoria"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria order by a.codigo asc");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where ca.nombre_categoria = :valor order by a.codigo asc; ");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            if($campo == "marca"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria order by a.codigo asc");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where m.nombre_marca = :valor order by a.codigo asc;");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            if($campo == "estado"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria order by a.codigo asc");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria where e.nombre_estado = :valor order by a.codigo asc;");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
            if($campo == "funcionario"){
                if($valor == "*"){
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join categoria ca on a.categoria_id = ca.id_categoria order by a.codigo asc");
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }else{
                    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.caracteristica from entrega_recepcion er inner join activo a on er.activo_id = a.id_activo inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join persona p on er.persona_id = p.id_persona where p.nombre_persona = :valor order by a.codigo asc;");
                    $stmt->bindValue(":valor", $valor, PDO::PARAM_STR);
                    $stmt->execute();
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                }
            }
        }
        
        public function cargarValor(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_categoria as nombre from categoria order by nombre_categoria asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
?>