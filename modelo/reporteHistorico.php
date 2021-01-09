<?php
    require('../fpdf/wrapper.php');
    require 'conexion.php';

    $conexion = new Conexion();

    $fechaTotal = getdate();

    $fechaInicio = $_GET['fechaInicio'];
    $fechaFinal = $_GET['fechaFinal'];
    $accion = $_GET['accion'];

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

    if($accion == "pdf"){
        class PDF extends Wrapper
    {
        function Header()
        {
            $this->Image('../assets/img/img_acta.png',25,10,40);
            $this->SetFont('Times','B',11);
            $this->Ln(10);
            $this->Cell(60);
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
            $this->MultiCell(0,3,utf8_decode("Puyo / Ecuador \n www.cnedppastaza.gob.ec \n Av. Alberto Zambrano \n Palacios s/n \n PBX: (593)2 885 145/885 359 \nFO-01(DG-SM-AD-09)"),0,'R');
            $this->Image('../assets/img/ec.png',180,265,2);
            $this->SetFont('Times','',10);
            $this->SetTextColor(0,0,0);
            $this->SetY(-15);
            $this->Cell(192,10,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'C');

        }
  
        function parrafo($texto)
        {
            $txt = $texto;
            $this->SetFont('Times','',10);
            $this->SetRightMargin(25);
            $this->SetLeftMargin(25);    
            $this->MultiCell(0,5,utf8_decode($txt)  );
            $this->Ln();
            $this->SetFont('','I');
        }
    }

        $pdf = new PDF();
        $pdf->AliasNbPages();
        $pdf->SetAutoPageBreak(true,40);
        $pdf->AddPage();
        $pdf->SetTextColor(17,86,160);
        $pdf->SetFont('Times','B',12);
        $pdf->SetX(23);
        $pdf->Cell(50,10,utf8_decode('REPORTE HISTORICO DE ACTIVOS'),0,1,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',12);
        $pdf->SetX(23);
        $pdf->MultiCell(0,5,utf8_decode("Fecha: $dia de $mes del $año"),0,'L');
        $pdf->Ln(5);

        // Cabecera de la tabla
        $pdf->SetFont('Times','B',12);
        $pdf->SetX(23);
        $pdf->Cell(18,10, "Codigo", 1,0,'C',0);
        $pdf->Cell(40,10, "Nombre", 1,0,'C',0);
        $pdf->Cell(28,10, "Marca", 1,0,'C',0);
        $pdf->Cell(28,10, "Modelo", 1,0,'C',0);
        $pdf->Cell(32,10, "Serie", 1,0,'C',0);
        $pdf->Cell(18,10, "Fecha", 1,1,'C',0);
        //definiar distancias de cada celda
        $pdf->SetWidths(Array(18,40,28,28,32,18));
        $pdf->SetLineHeight(5);
        $pdf->SetFont('Times','',8);
        
        $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, m.nombre_marca, a.serie, a.modelo, a.fecha_historico from activo a inner join marca m on a.marca_id = m.id_marca where (a.historico = 0) and (a.fecha_historico BETWEEN :fechaInicio AND :fechaFinal);");
        $stmt->bindValue(":fechaInicio",$fechaInicio, PDO::PARAM_STR);
        $stmt->bindValue(":fechaFinal",$fechaFinal, PDO::PARAM_STR);
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($datos as $row) {
            $pdf->Row(23, 0,Array(
                utf8_decode($row['codigo']),
                utf8_decode($row['nombre_activo']),
                utf8_decode($row['nombre_marca']),
                utf8_decode($row['modelo']),
                utf8_decode($row['serie']),
                utf8_decode($row['fecha_historico']),
            ), 'C');
        }
        $nombrePdf = "reporteHistorico";
        $pdf->Output('',nombrePdf($nombrePdf),true);

    }else{
        header('Content-type:application/xls');
        header('Content-Disposition: attachment; filename=reporteHistorico.xls');

        $stmt = $conexion->prepare("select a.id_activo, a.codigo, a.nombre_activo, m.nombre_marca, a.serie, a.modelo, a.fecha_historico from activo a inner join marca m on a.marca_id = m.id_marca where (a.historico = 0) and (a.fecha_historico BETWEEN :fechaInicio AND :fechaFinal);");
        $stmt->bindValue(":fechaInicio",$fechaInicio, PDO::PARAM_STR);
        $stmt->bindValue(":fechaFinal",$fechaFinal, PDO::PARAM_STR);
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $mostrar_columnas = false;

        foreach($datos as $row) {
          if(!$mostrar_columnas) {
            echo implode("\t", array_keys($row)) . "\n";
            $mostrar_columnas = true;
          }
          echo implode("\t", array_values($row)) . "\n";
        }
    }

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