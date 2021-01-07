<?php
    require('../fpdf/fpdf.php');
    require 'conexion.php';

    $conexion = new Conexion();

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
        class PDF extends FPDF
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
        $pdf->Cell(10,10, "Id", 1,0,'C',0);
        $pdf->Cell(18,10, "Codigo", 1,0,'C',0);
        $pdf->Cell(60,10, "Custodio", 1,0,'C',0);
        $pdf->Cell(60,10, "Funcionario", 1,0,'C',0);
        $pdf->Cell(18,10, "Fecha", 1,1,'C',0);
        $pdf->SetFont('Times','',8);
        
        $stmt = $conexion->prepare("select ma.id_movimiento_activo, a.codigo as codigo, p.nombre_persona as nombreCustodio, pe.nombre_persona as nombreFuncionario, ma.fecha_movimiento from movimiento_activo ma inner join activo a on ma.activo_id = a.id_activo inner join custodio cu on ma.custodio_id = cu.id_custodio inner join persona p on cu.persona_id = p.id_persona inner join persona pe on ma.persona_id = pe.id_persona where ma.fecha_movimiento BETWEEN :fechaInicio AND :fechaFinal;");
        $stmt->bindValue(":fechaInicio",$fechaInicio, PDO::PARAM_STR);
        $stmt->bindValue(":fechaFinal",$fechaFinal, PDO::PARAM_STR);
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($datos as $row) {
            $pdf->SetX(23);
            $pdf->Cell(10,10, $row['id_movimiento_activo'], 1,0,'C',0);
            $pdf->Cell(18,10, $row['codigo'], 1,0,'C',0);
            $pdf->Cell(60,10, $row['nombreCustodio'], 1,0,'C',0);
            $pdf->Cell(60,10, $row['nombreFuncionario'], 1,0,'C',0);
            $pdf->Cell(18,10, $row['fecha_movimiento'], 1,1,'C',0);
        }
        $pdf->Output();

    }else{
        header('Content-type:application/xls');
        header('Content-Disposition: attachment; filename=reporteHistorico.xls');

        $stmt = $conexion->prepare("select ma.id_movimiento_activo, a.codigo as codigo, p.nombre_persona as nombreCustodio, pe.nombre_persona as nombreFuncionario, ma.fecha_movimiento from movimiento_activo ma inner join activo a on ma.activo_id = a.id_activo inner join custodio cu on ma.custodio_id = cu.id_custodio inner join persona p on cu.persona_id = p.id_persona inner join persona pe on ma.persona_id = pe.id_persona where ma.fecha_movimiento BETWEEN :fechaInicio AND :fechaFinal;");
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

?>