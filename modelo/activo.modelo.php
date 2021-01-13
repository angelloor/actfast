<?php
    require 'conexion.php';

    class Activo{
        
        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where a.historico = 1 order by a.codigo asc limit 50");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idActivo){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.id_activo, c.nombre_categoria, m.nombre_marca, e.nombre_estado, co.nombre_color, a.caracteristica, b.nombre_bodega, p.nombre_persona, a.codigo, a.nombre_activo, a.modelo, a.serie, a.origen_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega b on a.bodega_id = b.id_bodega inner join custodio cu on a.custodio_id = cu.persona_id inner join persona p on cu.persona_id = p.id_persona where a.id_activo = :idactivo");
            $stmt->bindValue(":idactivo", $idActivo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idBuscar,$campoBuscar){
            $conexion = new Conexion();
            if($campoBuscar == "Codigo"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.codigo like :patron) and (a.historico = 1) order by a.codigo asc");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Nombre"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.nombre_activo like :patron) and (a.historico = 1) order by a.codigo asc");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Marca"){
                //obtener el id de la marca
                $stmt = $conexion->prepare("select id_marca from marca where nombre_marca = :nombremarca");
                $stmt->bindvalue(":nombremarca", $idBuscar, pdo::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idMarca = $results['id_marca'];
                
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.marca_id = :patron) and (a.historico = 1) order by a.codigo asc");
                $stmt->bindValue(":patron", $idMarca, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Modelo"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.modelo like :patron) and (a.historico = 1) order by a.codigo asc");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Serie"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.serie like :patron) and (a.historico = 1) order by a.codigo asc");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }

        public function Guardar($categoria,$marca ,$estado,$color,$caracteristica,$bodega,$custodio,$codigo,$nombre,$modelo,$serie,$origenIngreso,$fechaIngreso,$valorCompra,$comentario,$comprobacionInventario){
            $conexion = new Conexion();
            
            $stmt = $conexion->prepare("select count(*) from activo where (codigo = :codigo) and (historico = 0);");
            $stmt->bindValue(":codigo", $codigo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            if($existeRegistro >= 1){
                return "Activo ya existe ";
            }else{
                $stmt = $conexion->prepare("select id_categoria from categoria where nombre_categoria = :categoria");
                $stmt->bindValue(":categoria", $categoria, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idCategoria = $results['id_categoria'];

                $stmt = $conexion->prepare("select id_marca from marca where nombre_marca = :marca");
                $stmt->bindValue(":marca", $marca, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idMarca = $results['id_marca'];
                
                $stmt = $conexion->prepare("select id_estado from estado where nombre_estado = :estado");
                $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idEstado = $results['id_estado'];

                $stmt = $conexion->prepare("select id_color from color where nombre_color = :color");
                $stmt->bindValue(":color", $color, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idColor = $results['id_color'];

                $stmt = $conexion->prepare("select id_bodega from bodega where nombre_bodega = :bodega");
                $stmt->bindValue(":bodega", $bodega, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idBodega = $results['id_bodega'];

                $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :custodio");
                $stmt->bindValue(":custodio", $custodio, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idCustodio = $results['id_persona'];

                $stmt = $conexion->prepare("insert into `activo`(`categoria_id`, `marca_id`, `estado_id`, `color_id`, `caracteristica`, `bodega_id`, `custodio_id`, `codigo`, `nombre_activo`, `modelo`, `serie`, `origen_ingreso`,`fecha_ingreso`, `valor_compra`, `comentario`, `comprobacion_inventario`) values (:categoria,:marca ,:estado,:color,:caracteristica,:bodega,:custodio,:codigo,:nombre,:modelo,:serie,:origeningreso,:fechaingreso,:valorcompra,:comentario,:comprobacioninventario)");
                $stmt->bindValue(":categoria",$idCategoria, PDO::PARAM_INT);
                $stmt->bindValue(":marca",$idMarca, PDO::PARAM_INT);
                $stmt->bindValue(":estado",$idEstado, PDO::PARAM_INT);
                $stmt->bindValue(":color",$idColor, PDO::PARAM_INT);
                $stmt->bindValue(":caracteristica",$caracteristica, PDO::PARAM_STR);
                $stmt->bindValue(":bodega",$idBodega, PDO::PARAM_INT);
                $stmt->bindValue(":custodio",$idCustodio, PDO::PARAM_INT);
                $stmt->bindValue(":codigo",$codigo, PDO::PARAM_INT);
                $stmt->bindValue(":nombre",$nombre, PDO::PARAM_STR);
                $stmt->bindValue(":modelo",$modelo, PDO::PARAM_STR);
                $stmt->bindValue(":serie",$serie, PDO::PARAM_STR);
                $stmt->bindValue(":origeningreso",$origenIngreso, PDO::PARAM_STR);
                $stmt->bindValue(":fechaingreso",$fechaIngreso, PDO::PARAM_STR);
                $stmt->bindValue(":valorcompra",$valorCompra, PDO::PARAM_STR);
                $stmt->bindValue(":comentario",$comentario, PDO::PARAM_STR);
                $stmt->bindValue(":comprobacioninventario",$comprobacionInventario, PDO::PARAM_STR);
                
                if($stmt->execute()){
                    return "OK";
                }else{
                    return "Error: se ha generado un error al guardar la información";
                }
            }
        }

        public function Modificar($idActivo,$categoria,$marca ,$estado,$color,$caracteristica,$bodega,$custodio,$codigo,$nombre,$modelo,$serie,$origenIngreso,$fechaIngreso,$valorCompra,$comentario,$comprobacionInventario){
            $conexion = new Conexion();

            $stmt = $conexion->prepare("select count(*) from activo where (codigo = :codigo) and (historico = 0);");
            $stmt->bindValue(":codigo", $codigo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $existeRegistro = $results['count(*)'];
            
            $stmt = $conexion->prepare("select codigo from activo where id_activo = :idActivo;");
            $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $codigoBD = $results['codigo'];

            if ($codigo == $codigoBD) {
                $stmt = $conexion->prepare("select id_categoria from categoria where nombre_categoria = :categoria");
                    $stmt->bindValue(":categoria", $categoria, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idCategoria = $results['id_categoria'];
    
                    $stmt = $conexion->prepare("select id_marca from marca where nombre_marca = :marca");
                    $stmt->bindValue(":marca", $marca, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idMarca = $results['id_marca'];
                    
                    $stmt = $conexion->prepare("select id_estado from estado where nombre_estado = :estado");
                    $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idEstado = $results['id_estado'];
    
                    $stmt = $conexion->prepare("select id_color from color where nombre_color = :color");
                    $stmt->bindValue(":color", $color, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idColor = $results['id_color'];
    
                    $stmt = $conexion->prepare("select id_bodega from bodega where nombre_bodega = :bodega");
                    $stmt->bindValue(":bodega", $bodega, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idBodega = $results['id_bodega'];
    
                    $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :custodio");
                    $stmt->bindValue(":custodio", $custodio, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idCustodio = $results['id_persona'];
                
                    $stmt = $conexion->prepare("update `activo` set `categoria_id`= :categoria,
                    `marca_id`= :marca,`estado_id`= :estado,`color_id`= :color,`caracteristica`= :caracteristica,
                    `bodega_id`= :bodega,`custodio_id`= :custodio,`codigo`= :codigo,`nombre_activo`= :nombre,
                    `modelo`= :modelo,`serie`= :serie,`origen_ingreso`= :origeningreso,`fecha_ingreso`= :fechaingreso,
                    `valor_compra`= :valorcompra,`comentario`= :comentario,`comprobacion_inventario`= :comprobacioninventario where id_activo = :idactivo");
                
                    $stmt->bindValue(":categoria",$idCategoria, PDO::PARAM_INT);
                    $stmt->bindValue(":marca",$idMarca, PDO::PARAM_INT);
                    $stmt->bindValue(":estado",$idEstado, PDO::PARAM_INT);
                    $stmt->bindValue(":color",$idColor, PDO::PARAM_INT);
                    $stmt->bindValue(":caracteristica",$caracteristica, PDO::PARAM_STR);
                    $stmt->bindValue(":bodega",$idBodega, PDO::PARAM_INT);
                    $stmt->bindValue(":custodio",$idCustodio, PDO::PARAM_INT);
                    $stmt->bindValue(":codigo",$codigo, PDO::PARAM_INT);
                    $stmt->bindValue(":nombre",$nombre, PDO::PARAM_STR);
                    $stmt->bindValue(":modelo",$modelo, PDO::PARAM_STR);
                    $stmt->bindValue(":serie",$serie, PDO::PARAM_STR);
                    $stmt->bindValue(":origeningreso",$origenIngreso, PDO::PARAM_STR);
                    $stmt->bindValue(":fechaingreso",$fechaIngreso, PDO::PARAM_STR);
                    $stmt->bindValue(":valorcompra",$valorCompra, PDO::PARAM_STR);
                    $stmt->bindValue(":comentario",$comentario, PDO::PARAM_STR);
                    $stmt->bindValue(":comprobacioninventario",$comprobacionInventario, PDO::PARAM_STR);
                    $stmt->bindValue(":idactivo",$idActivo,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
            }else{
                if($existeRegistro >= 1){
                    return "El codigo ".$codigo." ya se esta utilizando en otro activo";
                }else{
                    $stmt = $conexion->prepare("select id_categoria from categoria where nombre_categoria = :categoria");
                    $stmt->bindValue(":categoria", $categoria, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idCategoria = $results['id_categoria'];
    
                    $stmt = $conexion->prepare("select id_marca from marca where nombre_marca = :marca");
                    $stmt->bindValue(":marca", $marca, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idMarca = $results['id_marca'];
                    
                    $stmt = $conexion->prepare("select id_estado from estado where nombre_estado = :estado");
                    $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idEstado = $results['id_estado'];
    
                    $stmt = $conexion->prepare("select id_color from color where nombre_color = :color");
                    $stmt->bindValue(":color", $color, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idColor = $results['id_color'];
    
                    $stmt = $conexion->prepare("select id_bodega from bodega where nombre_bodega = :bodega");
                    $stmt->bindValue(":bodega", $bodega, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idBodega = $results['id_bodega'];
    
                    $stmt = $conexion->prepare("select id_persona from persona where nombre_persona = :custodio");
                    $stmt->bindValue(":custodio", $custodio, PDO::PARAM_STR);
                    $stmt->execute();
                    $results = $stmt->fetch(PDO::FETCH_ASSOC);
                    $idCustodio = $results['id_persona'];
                
                    $stmt = $conexion->prepare("update `activo` set `categoria_id`= :categoria,
                    `marca_id`= :marca,`estado_id`= :estado,`color_id`= :color,`caracteristica`= :caracteristica,
                    `bodega_id`= :bodega,`custodio_id`= :custodio,`codigo`= :codigo,`nombre_activo`= :nombre,
                    `modelo`= :modelo,`serie`= :serie,`origen_ingreso`= :origeningreso,`fecha_ingreso`= :fechaingreso,
                    `valor_compra`= :valorcompra,`comentario`= :comentario,`comprobacion_inventario`= :comprobacioninventario where id_activo = :idactivo");
                
                    $stmt->bindValue(":categoria",$idCategoria, PDO::PARAM_INT);
                    $stmt->bindValue(":marca",$idMarca, PDO::PARAM_INT);
                    $stmt->bindValue(":estado",$idEstado, PDO::PARAM_INT);
                    $stmt->bindValue(":color",$idColor, PDO::PARAM_INT);
                    $stmt->bindValue(":caracteristica",$caracteristica, PDO::PARAM_STR);
                    $stmt->bindValue(":bodega",$idBodega, PDO::PARAM_INT);
                    $stmt->bindValue(":custodio",$idCustodio, PDO::PARAM_INT);
                    $stmt->bindValue(":codigo",$codigo, PDO::PARAM_INT);
                    $stmt->bindValue(":nombre",$nombre, PDO::PARAM_STR);
                    $stmt->bindValue(":modelo",$modelo, PDO::PARAM_STR);
                    $stmt->bindValue(":serie",$serie, PDO::PARAM_STR);
                    $stmt->bindValue(":origeningreso",$origenIngreso, PDO::PARAM_STR);
                    $stmt->bindValue(":fechaingreso",$fechaIngreso, PDO::PARAM_STR);
                    $stmt->bindValue(":valorcompra",$valorCompra, PDO::PARAM_STR);
                    $stmt->bindValue(":comentario",$comentario, PDO::PARAM_STR);
                    $stmt->bindValue(":comprobacioninventario",$comprobacionInventario, PDO::PARAM_STR);
                    $stmt->bindValue(":idactivo",$idActivo,PDO::PARAM_INT); 
                    if($stmt->execute()){
                        return "OK";
                    }else{
                        return "Error: se ha generado un error al modificar la información";
                    }
                }
            }
        }

        public function Eliminar($idActivo,$fechaEliminar){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("update `activo` set `historico` = 0, `fecha_historico` = :fechaeliminar  where id_activo = :idactivo");
            $stmt->bindValue(":idactivo",$idActivo, PDO::PARAM_INT);
            $stmt->bindValue(":fechaeliminar",$fechaEliminar, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

        public function listarCategoria(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_categoria from categoria order by nombre_categoria asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarMarca(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_marca from marca order by nombre_marca asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarEstado(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_estado from estado order by nombre_estado asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarColor(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_color from color order by nombre_color asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarBodega(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select nombre_bodega from bodega order by nombre_bodega asc;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarCustodio(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona order by p.nombre_persona asc;;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function consultarRegistros($idActivo){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select count(*) as registros from entrega_recepcion where activo_id = :idActivo;");
            $stmt->bindValue(":idActivo",$idActivo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

    }
?>