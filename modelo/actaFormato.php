<?php
    require('../fpdf/fpdf.php');
    require 'conexion.php';

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
    
    
    class PDF extends FPDF
    {
        function Header()
        {
            $this->Image('../assets/img/img_acta.png',25,10,40);
            $this->SetFont('Arial','',10);
            $this->Ln(5);
            $this->Cell(70);
            $this->SetTextColor(42,81,147);
            $this->MultiCell(105,5,utf8_decode('UNIDAD PROVINCIAL DE SEGURIDAD INFORMÁTICA Y PROYECTOS TECNOLÓGICOS ELECTORALES DE PASTAZA'));
            $this->Ln(15);
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
            $this->MultiCell(0,3,utf8_decode("Puyo / Ecuador \n www.cnedppastaza.gob.ec \n Av. Alberto Zambrano \n Palacios s/n \n PBX: (593)2 885 145/885 359 \n"),0,'R');
            $this->Image('../assets/img/ec.png',180,265,2);

        }
        function parrafo($texto)
        {
            $txt = $texto;
            $this->SetFont('Times','',12);
            $this->SetRightMargin(25);
            $this->SetLeftMargin(25);    
            $this->MultiCell(0,5,utf8_decode($txt)  );
            $this->Ln();
            $this->SetFont('','I');
        }
    }
    
    $pdf = new PDF();
    $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->SetTextColor(31,78,121);
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(0,10,utf8_decode('ACTA DE ENTREGA RECEPCIÓN'),0,1,'C');
    $pdf->SetTextColor(0,0,0);
    $pdf->parrafo("En la ciudad de Puyo, a los $dia días del mes de $mes del $año, se procede a realizar el acta de entrega entre Ing. $custodio, $cargo_custodio, $unidad_custodio y $nuevo_a_cargo con C.I. $ci_nuevo_a_cargo, $cargo_nuevo_a_cargo,  de los siguientes equipos  informáticos:");
    $pdf->parrafo("Equipos informáticos y cables de poder que se encuentran en perfectas condiciones de funcionamiento en caso de pérdida, daño o deterioro de los mismos quedaran a su entera responsabilidad.
    Para lo actuado las partes firman en duplicado de igual valor y contenido.
    ");
    
    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,utf8_decode('ENTREGAN CONFORME'),0,1,'C');

    $pdf->ln(15);
    $pdf->Cell(1,10,utf8_decode("$custodio_uno"));
    $pdf->Cell(5,20,utf8_decode("       $cargo_custodio_uno"));
    $pdf->Cell(5,30,utf8_decode("    CNE-PASTAZA"));
  
    $pdf->Cell(90,10,utf8_decode(""));
    $pdf->Cell(1,10,utf8_decode("$custodio_dos"));
    $pdf->Cell(1,20,utf8_decode("$cargo_custodio_dos"));
    $pdf->Cell(1,30,utf8_decode("       CNE-PASTAZA"));
    
    $pdf->ln(25);
    $pdf->Cell(0,10,utf8_decode('RECIBÍ CONFORME'),0,1,'C');
    $pdf->ln(15);

    $pdf->MultiCell(0,5,utf8_decode("$nuevo_a_cargo \n $cargo_nuevo_a_cargo"),0,'C');
    $pdf->Output();

?>