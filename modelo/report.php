
<?php
    require('../fpdf/fpdf.php');
    require 'conexion.php';
    $conexion = new Conexion();

    class PDF extends FPDF
    {
        // Cabecera de página
        function Header()
        {
            // Logo
            $this->Image('../assets/img/img_acta.png',25,10,40);
            // Arial bold 15
            $this->SetFont('Arial','',10);
            // Movernos a la derecha
            $this->Ln(5);
            $this->Cell(70);
            // Título
        
            $this->SetTextColor(42,81,147);
            $this->MultiCell(105,5,utf8_decode('UNIDAD PROVINCIAL DE SEGURIDAD INFORMÁTICA Y PROYECTOS TECNOLÓGICOS ELECTORALES DE PASTAZA'));
            //$this->SetDrawColor(42,81,147); 
        // $this->SetLineWidth(0.5); 
            //$this->Line(80, 45, 185, 45);
            // Salto de línea
            $this->Ln(15);
        }
        
        function parrafo($texto)
        {
            // Leemos el fichero
            $txt = $texto;
            // Times 12
            $this->SetFont('Times','',12);
            // Imprimimos el texto justificado
            $this->SetRightMargin(25);
            $this->SetLeftMargin(25);    
            $this->MultiCell(0,5,utf8_decode($txt)  );
            // Salto de línea
            $this->Ln();
            // Cita en itálica
            $this->SetFont('','I');
        }
    }
    
    // Creación del objeto de la clase heredada
    $pdf = new PDF('L','mm','A4');
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTextColor(31,78,121);
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(0,10,utf8_decode('REPORTE DE ACTIVOS'),0,1,'C');
    $pdf->SetTextColor(0,0,0);
   
    // Logica del reporte 
    
    $categoria = $_POST['categoria'];
    $marca = $_POST['marca'];
    $estado = $_POST['estado'];
    $custodio = $_POST['custodio'];
    $funcionario = $_POST['funcionario'];

    // Condicionar la seleccion
    if ($categoria == "*" && $marca == "*" && $estado == "*" && $custodio == "*" && $funcionario == "*") {
        $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado order by nombre_activo asc;");
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Cabecera de la tabla
        $pdf->Cell(20,10, "codigo", 1,0,'C',0);
        $pdf->Cell(70,10, "Nombre", 1,0,'C',0);
        $pdf->Cell(55,10, "Caracteristica", 1,0,'C',0);
        $pdf->Cell(35,10, "Marca", 1,0,'C',0);
        $pdf->Cell(35,10, "Modelo", 1,0,'C',0);
        $pdf->Cell(40,10, "Serie", 1,0,'C',0);
        $pdf->Cell(20,10, "Estado", 1,1,'C',0);
        $pdf->SetFont('Times','',10);

        // datos de la tabla
        foreach ($datos as $row) {
            $pdf->Cell(20,10, $row['codigo'], 1,0,'C',0);
            $pdf->Cell(70,10, $row['nombre_activo'], 1,0,'C',0);
            $pdf->Cell(55,10, $row['caracteristica'], 1,0,'C',0);
            $pdf->Cell(35,10, $row['nombre_marca'], 1,0,'C',0);
            $pdf->Cell(35,10, $row['modelo'], 1,0,'C',0);
            $pdf->Cell(40,10, $row['serie'], 1,0,'C',0);
            $pdf->Cell(20,10, $row['nombre_estado'], 1,1,'C',0);

        }

    }

    if ($categoria != "*" && $marca != "*" && $estado != "*" && $custodio != "*" && $funcionario != "*") {
         // Sacar los id de los String
        $stmt = $conexion->prepare("select ID_CATEGORIA FROM categoria where nombre_categoria = :nombreCategria");
        $stmt->bindValue(":nombreCategria", $categoria, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idCategoria = $results['ID_CATEGORIA'];

        $stmt = $conexion->prepare("select ID_MARCA FROM marca where nombre_marca = :nombreMarca");
        $stmt->bindValue(":nombreMarca", $marca, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idMarca = $results['ID_MARCA'];

        $stmt = $conexion->prepare("select ID_ESTADO FROM estado where nombre_estado = :nombreEstado");
        $stmt->bindValue(":nombreEstado", $estado, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idEstado = $results['ID_ESTADO'];

        $stmt = $conexion->prepare(" select cu.id_custodio FROM custodio cu inner join persona p on cu.persona_id = p.id_persona where p.nombre_persona = :nombreCustodio");
        $stmt->bindValue(":nombreCustodio", $custodio, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idCustodio = $results['id_custodio'];

        $stmt = $conexion->prepare("select ID_PERSONA FROM persona where nombre_persona = :nombrePersona");
        $stmt->bindValue(":nombrePersona", $funcionario, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetch(PDO::FETCH_ASSOC);
        $idPersona = $results['ID_PERSONA'];     

        $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from entrega_recepcion er inner join persona p on er.persona_id = p.id_persona  inner join activo a on er.activo_id = a.id_activo inner join marca m on a.marca_id = m.id_marca inner join categoria c on a.categoria_id = c.id_categoria inner join estado e on a.estado_id = e.id_estado inner join custodio cu on er.custodio_id = cu.id_custodio where c.id_categoria = :idCategoria and m.id_marca = :idMarca and e.id_estado = :idEstado and cu.id_custodio = :idCustodio and p.id_persona = :idPersona");
        $stmt->bindValue(":idCategoria", $idCategoria,PDO::PARAM_INT);
        $stmt->bindValue(":idMarca", $idMarca,PDO::PARAM_INT);
        $stmt->bindValue(":idEstado", $idEstado,PDO::PARAM_INT);
        $stmt->bindValue(":idCustodio", $idCustodio,PDO::PARAM_INT);
        $stmt->bindValue(":idPersona", $idPersona,PDO::PARAM_INT);
        $stmt->execute();
        $stmt->fetchAll(PDO::FETCH_OBJ);
        $pdf->Cell(0,10,utf8_decode("Seleciona todo"),0,1,'C');
    }




    $pdf->Output();
?>