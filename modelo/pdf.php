<?php
    require('../fpdf/wrapper.php');
    require 'conexion.php';
    $conexion = new Conexion();

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
        $pdf->SetTextColor(17,86,160);
        $pdf->SetFont('Times','B',12);
        $pdf->SetX(23);
        $pdf->Cell(50,10,utf8_decode('REPORTE DE ACTIVOS NO CONFIRMADOS'),0,1,'L');
        $pdf->SetTextColor(0,0,0);
        $pdf->SetFont('Times','',12);
        $pdf->SetX(23);
        $pdf->MultiCell(0,5,utf8_decode("Fecha: $dia de $mes del $año"),0,'L');
   
        $stmt = $conexion->prepare("select a.codigo, a.nombre_activo, a.caracteristica, m.nombre_marca, a.modelo, a.serie, e.nombre_estado from activo a inner join marca m on a.marca_id = m.id_marca inner join estado e on a.estado_id = e.id_estado where a.comprobacion_inventario = 'NO' order by nombre_activo asc;");
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
        $pdf->SetWidths(Array(18,65,50,30,30,35,20));
        $pdf->SetLineHeight(5);
        $pdf->SetFont('Times','',10);
        // datos de la tabla
        foreach ($datos as $row) {
            $pdf->Row(23, 0,Array(
                $row['codigo'],
                $row['nombre_activo'],
                $row['caracteristica'],
                $row['nombre_marca'],
                $row['modelo'],
                $row['serie'],
                $row['nombre_estado'],
            ), 'C');
        }

    $pdf->Output();
?>