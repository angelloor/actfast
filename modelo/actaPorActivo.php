<?php
    require('../fpdf/wrapper.php');
    require 'conexion.php';

    $activo = $_GET['activo'];

    $ciudad="Puyo";
    $dia=date("d");
    $mes_inicial=date("F");
    $año=date("Y");
    function mes_format($mes_inicial){
        if ($mes_inicial == "January") $mes = "Enero";
        if ($mes_inicial == "February") $mes = "Febrero";
        if ($mes_inicial == "March") $mes = "Marzo";
        if ($mes_inicial == "April") $mes = "Abril";
        if ($mes_inicial == "May") $mes = "Mayo";
        if ($mes_inicial == "June") $mes = "Junio";
        if ($mes_inicial == "July") $mes = "Julio";
        if ($mes_inicial == "August") $mes = "Agosto";
        if ($mes_inicial == "September") $mes = "Setiembre";
        if ($mes_inicial == "October") $mes = "Octubre";
        if ($mes_inicial == "November") $mes = "Noviembre";
        if ($mes_inicial == "December") $mes = "Diciembre";
        return $mes;
    }
    $mes = mes_format($mes_inicial);

    $custodio="RICARDO CARDENAS";
    $cargo_custodio="Técnico Electoral 2";
    $unidad_custodio="UNIDAD PROVINCIAL DE SEGURIDAD INFORMÁTICA Y PROYECTOS TECNOLÓGICOS ELECTORALES";
    $nuevo_a_cargo="BARRIGA CHAVEZ STALIN JOUSEPH";
    $ci_nuevo_a_cargo="1600634925";
    $cargo_nuevo_a_cargo="ASISTENTE ADMINISTRATIVO ELECTORAL PROVINCIAL"; 
    $custodio_uno = "ING. ". $custodio;
    $cargo_custodio_uno = $cargo_custodio;
    $custodio_dos = "LIC. LADY VINCES M.";
    $cargo_custodio_dos = "TÉCNICO  ELECTORAL 1	";
    
    
    class PDF extends Wrapper
    {
        function Header()
        {
            $this->Image('../assets/img/img_acta.png',25,10,40);
            $this->SetFont('Times','B',11);
            $this->Ln(10);
            $this->Cell(45);
            $this->SetTextColor(31,78,121);
            $this->MultiCell(115,5,utf8_decode('UNIDAD PROVINCIAL DE SEGURIDAD INFORMÁTICA Y PROYECTOS TECNOLÓGICOS ELECTORALES DE PASTAZA'));
            $this->Ln(5);
        }
        
        function Footer()
        {
            $this->SetY(-25);
            $this->SetX(30);
            $this->SetTextColor(183,191,214);
            $this->SetFont('Times','I',24);
            $this->Cell(0,10,utf8_decode('Construyendo Democracia'),0,1,'L');
            $this->SetY(-30);
            $this->SetX(0);
            $this->SetTextColor(42,81,147);
            $this->SetFont('Times','',8);
            $this->SetRightMargin(33);
            $this->MultiCell(0,3,utf8_decode("Puyo / Ecuador \n www.cnedppastaza.gob.ec \n Av. Alberto Zambrano \n Palacios s/n \n PBX: (593)2 885 145/885 359"),0,'R');
            $this->Image('../assets/img/ec.png',180,265,2);
            $this->SetFont('Times','',10);
            $this->SetTextColor(0,0,0);
            $this->Cell(165,10,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'C');

        }
        
        function parrafo($texto)
        {
            $txt = $texto;
            $this->SetFont('Times','',10);  
            $this->MultiCell(0,5,utf8_decode($txt)  );
            $this->SetFont('','I');
        }
    }
    
    $pdf = new PDF();
    $pdf->SetRightMargin(25);
    $pdf->SetLeftMargin(25);  
    $pdf->AliasNbPages();
    $pdf->SetAutoPageBreak(true,35);
    $pdf->AddPage();
    $pdf->SetTextColor(31,78,121);
    $pdf->SetFont('Times','B',12);
    $pdf->Ln();
    $pdf->Cell(0,10,utf8_decode('ACTA ENTREGA RECEPCIÓN'),0,1,'C');
    $pdf->SetTextColor(0,0,0);
    $pdf->parrafo("En la ciudad de Puyo, a los $dia días del mes de $mes del $año, se procede a realizar el acta de entrega entre Ing. $custodio, $cargo_custodio, $unidad_custodio y $nuevo_a_cargo con C.I. $ci_nuevo_a_cargo, $cargo_nuevo_a_cargo,  de los siguientes equipos  informáticos:");
    
    $conexion = new Conexion();
    $stmt = $conexion->prepare("select a.nombre_activo, m.nombre_marca, a.modelo, a.caracteristica, a.serie from activo a inner join marca m on a.marca_id = m.id_marca inner join categoria c on a.categoria_id = c.id_categoria where c.id_categoria = 1 limit 10;");
    $stmt->execute();
    $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
     // Cabecera de la tabla
     $pdf->SetFont('Times','B',10);
     $pdf->SetX(25);
    $pdf->ln(5);

     $pdf->Cell(120,6, utf8_decode("DESCRIPCIÓN DEL BIEN"), 1,0,'C',0);
     $pdf->Cell(40,6, "SERIE", 1,1,'C',0);
     //definiar distancias de cada celda
     $pdf->SetWidths(Array(120,40));
     $pdf->SetLineHeight(5);
     $pdf->SetFont('Times','',8);

     foreach ($datos as $row) {
        $pdf->Row(25, 0,Array(
            $row['nombre_activo']." ".$row['nombre_marca']." ".$row['modelo']." ".$row['caracteristica'],
            $row['serie'],
        ), 'C');
    }

    $pdf->ln(5);
    $pdf->parrafo("Equipos informáticos y cables de poder que se encuentran en perfectas condiciones de funcionamiento en caso de pérdida, daño o deterioro de los mismos quedaran a su entera responsabilidad. \n\nPara lo actuado las partes firman en duplicado de igual valor y contenido.");
    
    $pdf->SetFont('Times','B',10);
    $pdf->ln(5);
    $pdf->Cell(0,10,utf8_decode('ENTREGAN CONFORME'),0,1,'C');
    $pdf->SetFont('Times','',10);
    $pdf->ln(10);
    $pdf->Cell(80,6,utf8_decode("$custodio_uno"),0,0,'C',0);
    $pdf->Cell(80,6,utf8_decode("$custodio_uno"),0,1,'C',0);
    $pdf->Cell(80,6,utf8_decode("$cargo_custodio_uno"),0,0,'C',0);
    $pdf->Cell(80,6,utf8_decode("$cargo_custodio_dos"),0,1,'C',0);
    $pdf->Cell(80,6,utf8_decode("CNE-PASTAZA"),0,0,'C',0);
    $pdf->Cell(80,6,utf8_decode("CNE-PASTAZA"),0,1,'C',0);
    $pdf->ln(5);
    $pdf->SetFont('Times','B',10);
    $pdf->Cell(0,10,utf8_decode('RECIBÍ CONFORME'),0,1,'C');
    $pdf->SetFont('Times','',10);
    $pdf->ln(10);
    $pdf->MultiCell(0,5,utf8_decode("$nuevo_a_cargo \n $cargo_nuevo_a_cargo"),0,'C');
    
    $nombrePdf = "actaDigital".$custodio;
    $pdf->Output('',nombrePdf($nombrePdf),true);

    function nombrePdf($nombre){
        $fechaTotal = getdate();
        if($fechaTotal['wday'] <= 9){
            $dia = "0".$fechaTotal['wday'];
        }
        if($fechaTotal['mon'] <= 9){
            $mes = "0".$fechaTotal['mon'];
        }
        $fechaFinal = $fechaTotal['year']."-".$mes."-".$dia;
        $nombreFinal = $nombre.$fechaFinal.".pdf";
        return $nombreFinal;
    }

?>

