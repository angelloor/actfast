<?php
    require 'conexion.php';

    class Activo{
        public function ConsultarTodo(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where a.historico = 1 order by a.id_activo asc limit 50");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function ConsultarPorId($idActivo){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select a.id_activo, c.nombre_categoria, m.nombre_marca, e.nombre_estado, co.nombre_color, a.caracteristica, b.nombre_bodega, p.nombre_persona, a.codigo, a.nombre_activo, a.modelo, a.serie, a.origen_ingreso, a.fecha_ingreso, a.valor_compra, a.comentario, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado inner join color co on a.color_id = co.id_color inner join bodega b on a.bodega_id = b.id_bodega inner join custodio cu on a.custodio_id = cu.persona_id inner join persona p on cu.persona_id = p.id_persona where a.id_activo = :idActivo");
            $stmt->bindValue(":idActivo", $idActivo, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_OBJ);
        }

        public function ConsultarPorIdRow($idBuscar,$campoBuscar){
            $conexion = new Conexion();
            if($campoBuscar == "Codigo"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado WHERE (a.codigo LIKE :patron) and (a.historico = 1)");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Nombre"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado WHERE (a.nombre_activo LIKE :patron) and (a.historico = 1)");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Marca"){
                //obtener el id de la marca
                $stmt = $conexion->prepare("select ID_MARCA FROM MARCA where NOMBRE_MARCA = :nombreMarca");
                $stmt->bindValue(":nombreMarca", $idBuscar, PDO::PARAM_STR);
                $stmt->execute();
                $results = $stmt->fetch(PDO::FETCH_ASSOC);
                $idMarca = $results['ID_MARCA'];
                
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado WHERE (a.marca_id = :patron) and (a.historico = 1)");
                $stmt->bindValue(":patron", $idMarca, PDO::PARAM_INT);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Modelo"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado WHERE (a.modelo LIKE :patron) and (a.historico = 1)");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
            if($campoBuscar == "Serie"){
                $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, c.nombre_categoria, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado, a.comprobacion_inventario from activo a inner join categoria c on a.categoria_id = c.id_categoria inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado WHERE (a.serie LIKE :patron) and (a.historico = 1)");
                $stmt->bindValue(":patron", "%".$idBuscar."%", PDO::PARAM_STR);
                $stmt->execute();
                return $stmt->fetchAll(PDO::FETCH_OBJ);
            }
        }

        public function Guardar($categoria,$marca ,$estado,$color,$caracteristica,$bodega,$custodio,$codigo,$nombre,$modelo,$serie,$origenIngreso,$fechaIngreso,$valorCompra,$comentario,$comprobacionInventario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT ID_CATEGORIA FROM CATEGORIA WHERE NOMBRE_CATEGORIA = :categoria");
            $stmt->bindValue(":categoria", $categoria, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCategoria = $results['ID_CATEGORIA'];

            $stmt = $conexion->prepare("SELECT ID_MARCA FROM MARCA WHERE NOMBRE_MARCA = :marca");
            $stmt->bindValue(":marca", $marca, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idMarca = $results['ID_MARCA'];
            
            $stmt = $conexion->prepare("SELECT ID_ESTADO FROM ESTADO WHERE NOMBRE_ESTADO = :estado");
            $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idEstado = $results['ID_ESTADO'];

            $stmt = $conexion->prepare("SELECT ID_COLOR FROM COLOR WHERE NOMBRE_COLOR = :color");
            $stmt->bindValue(":color", $color, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idColor = $results['ID_COLOR'];

            $stmt = $conexion->prepare("SELECT ID_BODEGA FROM BODEGA WHERE NOMBRE_BODEGA = :bodega");
            $stmt->bindValue(":bodega", $bodega, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idBodega = $results['ID_BODEGA'];

            $stmt = $conexion->prepare("SELECT ID_PERSONA FROM PERSONA WHERE NOMBRE_PERSONA = :custodio");
            $stmt->bindValue(":custodio", $custodio, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCustodio = $results['ID_PERSONA'];

            $stmt = $conexion->prepare("INSERT INTO `activo`(`CATEGORIA_ID`, `MARCA_ID`, `ESTADO_ID`, `COLOR_ID`, `CARACTERISTICA`, `BODEGA_ID`, `CUSTODIO_ID`, `CODIGO`, `NOMBRE_ACTIVO`, `MODELO`, `SERIE`, `ORIGEN_INGRESO`,`FECHA_INGRESO`, `VALOR_COMPRA`, `COMENTARIO`, `COMPROBACION_INVENTARIO`) VALUES (:categoria,:marca ,:estado,:color,:caracteristica,:bodega,:custodio,:codigo,:nombre,:modelo,:serie,:origenIngreso,:fechaIngreso,:valorCompra,:comentario,:comprobacionInventario)");
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
            $stmt->bindValue(":origenIngreso",$origenIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":fechaIngreso",$fechaIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":valorCompra",$valorCompra, PDO::PARAM_STR);
            $stmt->bindValue(":comentario",$comentario, PDO::PARAM_STR);
            $stmt->bindValue(":comprobacionInventario",$comprobacionInventario, PDO::PARAM_STR);
            
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al guardar la información";
            }
        }

        public function Modificar($idActivo,$categoria,$marca ,$estado,$color,$caracteristica,$bodega,$custodio,$codigo,$nombre,$modelo,$serie,$origenIngreso,$fechaIngreso,$valorCompra,$comentario,$comprobacionInventario){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT ID_CATEGORIA FROM CATEGORIA WHERE NOMBRE_CATEGORIA = :categoria");
            $stmt->bindValue(":categoria", $categoria, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCategoria = $results['ID_CATEGORIA'];

            $stmt = $conexion->prepare("SELECT ID_MARCA FROM MARCA WHERE NOMBRE_MARCA = :marca");
            $stmt->bindValue(":marca", $marca, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idMarca = $results['ID_MARCA'];
            
            $stmt = $conexion->prepare("SELECT ID_ESTADO FROM ESTADO WHERE NOMBRE_ESTADO = :estado");
            $stmt->bindValue(":estado", $estado, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idEstado = $results['ID_ESTADO'];

            $stmt = $conexion->prepare("SELECT ID_COLOR FROM COLOR WHERE NOMBRE_COLOR = :color");
            $stmt->bindValue(":color", $color, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idColor = $results['ID_COLOR'];

            $stmt = $conexion->prepare("SELECT ID_BODEGA FROM BODEGA WHERE NOMBRE_BODEGA = :bodega");
            $stmt->bindValue(":bodega", $bodega, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idBodega = $results['ID_BODEGA'];

            $stmt = $conexion->prepare("SELECT ID_PERSONA FROM PERSONA WHERE NOMBRE_PERSONA = :custodio");
            $stmt->bindValue(":custodio", $custodio, PDO::PARAM_STR);
            $stmt->execute();
            $results = $stmt->fetch(PDO::FETCH_ASSOC);
            $idCustodio = $results['ID_PERSONA'];
           
            $stmt = $conexion->prepare("UPDATE `activo` SET `CATEGORIA_ID`= :categoria,
            `MARCA_ID`= :marca,`ESTADO_ID`= :estado,`COLOR_ID`= :color,`CARACTERISTICA`= :caracteristica,
            `BODEGA_ID`= :bodega,`CUSTODIO_ID`= :custodio,`CODIGO`= :codigo,`NOMBRE_ACTIVO`= :nombre,
            `MODELO`= :modelo,`SERIE`= :serie,`ORIGEN_INGRESO`= :origenIngreso,`FECHA_INGRESO`= :fechaIngreso,
            `VALOR_COMPRA`= :valorCompra,`COMENTARIO`= :comentario,`COMPROBACION_INVENTARIO`= :comprobacionInventario WHERE ID_ACTIVO = :idActivo");
           
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
            $stmt->bindValue(":origenIngreso",$origenIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":fechaIngreso",$fechaIngreso, PDO::PARAM_STR);
            $stmt->bindValue(":valorCompra",$valorCompra, PDO::PARAM_STR);
            $stmt->bindValue(":comentario",$comentario, PDO::PARAM_STR);
            $stmt->bindValue(":comprobacionInventario",$comprobacionInventario, PDO::PARAM_STR);
            $stmt->bindValue(":idActivo",$idActivo,PDO::PARAM_INT); 
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al modificar la información";
            }
        }

        public function Eliminar($idActivo,$fechaEliminar){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("UPDATE `activo` SET `HISTORICO` = 0, `FECHA_HISTORICO` = :fechaEliminar  WHERE ID_ACTIVO = :idActivo");
            $stmt->bindValue(":idActivo",$idActivo, PDO::PARAM_INT);
            $stmt->bindValue(":fechaEliminar",$fechaEliminar, PDO::PARAM_STR);
            if($stmt->execute()){
                return "OK";
            }else{
                return "Error: se ha generado un error al eliminar el registro";
            }
        }

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

        public function listarColor(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_COLOR FROM COLOR");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarBodega(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("SELECT NOMBRE_BODEGA FROM BODEGA");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }

        public function listarCustodio(){
            $conexion = new Conexion();
            $stmt = $conexion->prepare("select p.nombre_persona from custodio c inner join persona p on c.persona_id = p.id_persona;");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
     
    }


?>