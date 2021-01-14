<?php
    require('../fpdf/wrapper.php');
    require 'conexion.php';
    $conexion = new Conexion();
    $accion = $_GET['accion'];

    $fechaTotal = getdate();

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
                $this->SetFont('Times','',15);
                $this->Ln(10);
                $this->Cell(60);
                $this->SetTextColor(17,86,160);
                $this->MultiCell(200,5,utf8_decode('UNIDAD PROVINCIAL DE SEGURIDAD INFORMÁTICA Y PROYECTOS TECNOLÓGICOS ELECTORALES DE PASTAZA'));
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
                $this->Image('../assets/img/ec.png',265,178,2);
                $this->SetFont('Times','',10);
                $this->SetTextColor(0,0,0);
                $this->SetY(-15);
                $this->Cell(280,10,utf8_decode('Página ').$this->PageNo().' / {nb}',0,0,'C');
    
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
    
        $pdf = new PDF('L','mm','A4');
          
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetAutoPageBreak(true,45);
        $pdf->SetTextColor(17,86,160);
        $pdf->SetFont('Times','B',12);
        $pdf->SetX(23);
        $pdf->Cell(50,10,utf8_decode('REPORTE DE ACTIVOS CONFIRMADOS'),0,1,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',12);
        $pdf->SetX(23);
        $pdf->MultiCell(0,5,utf8_decode("Fecha: $dia de $mes del $año"),0,'L');
   
        $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.comprobacion_inventario = 'SI') and (a.historico = 1) order by a.codigo asc;");
        $stmt->execute();
        $datos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pdf->Ln(5);
        
            // Cabecera de la tabla
        $pdf->SetFont('Times','B',12);
        $pdf->SetX(23);
        $pdf->Cell(18,10, "Codigo", 1,0,'C',0);
        $pdf->Cell(65,10, "Nombre", 1,0,'C',0);
        $pdf->Cell(50,10, "Caracteristica", 1,0,'C',0);
        $pdf->Cell(30,10, "Marca", 1,0,'C',0);
        $pdf->Cell(30,10, "Modelo", 1,0,'C',0);
        $pdf->Cell(35,10, "Serie", 1,0,'C',0);
        $pdf->Cell(20,10, "Estado", 1,1,'C',0);
        //definiar distancias de cada celda
        $pdf->SetWidths(Array(18,65,50,30,30,35,20));
        $pdf->SetLineHeight(5);

        $pdf->SetFont('Times','',10);

            // datos de la tabla
        foreach ($datos as $row) {
            $pdf->Row(23, 0,Array(
                utf8_decode($row['codigo']),
                utf8_decode($row['nombre_activo']),
                utf8_decode($row['caracteristica']),
                utf8_decode($row['nombre_marca']),
                utf8_decode($row['modelo']),
                utf8_decode($row['serie']),
                utf8_decode($row['nombre_estado']),
            ), 'C');
        }
        $nombrePdf = "activosConfirmados";
        $pdf->Output('',nombrePdf($nombrePdf),true);


    }else{
  
        header('Content-type:application/xls');
        header('Content-Disposition: attachment; filename=reporteConfirmados.xls');

        $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where (a.comprobacion_inventario = 'SI') and (a.historico = 1) order by a.codigo asc;");
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