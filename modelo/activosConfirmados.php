
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
    $pdf->Cell(0,10,utf8_decode('REPORTE ACTIVOS CONFIRMADOS'),0,1,'C');
    $pdf->SetTextColor(0,0,0);
   
    // Logica del reporte 
    $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where a.comprobacion_inventario = 'SI' order by nombre_activo asc;");
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


    $pdf->Output();
?>