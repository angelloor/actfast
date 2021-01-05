<?php
    require('../fpdf/fpdf.php');
    require 'conexion.php';

    $totalSistemas = $_GET['totalSistemas'];
    $periodo = $_GET['periodo'];
    $nombreFuncionario = $_GET['funcionario'];

    $conexion = new Conexion();
    $stmt = $conexion->prepare("select p.cedula, c.nombre_cargo from persona p inner join cargo c on p.cargo_id = c.id_cargo where p.nombre_persona = :nombrePersona;");
    $stmt->bindValue(":nombrePersona", $nombreFuncionario, PDO::PARAM_STR);
    $stmt->execute();
    $results = $stmt->fetch(PDO::FETCH_ASSOC);
    $cedula = $results['cedula'];
    $nombreCargo = $results['nombre_cargo'];
    
    $sistemas = "";
    $credenciales = "";

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

    $totalSistemas = $_GET['totalSistemas'];

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
    $pdf->Cell(0,10,utf8_decode('ACTA ENTREGA RECEPCION DE CREDENCIALES DIGITALES'),0,1,'C');
    $pdf->SetTextColor(0,0,0);
    $pdf->parrafo("La presente acta de entrega recepción tiene por objeto otorgar credenciales para el manejo de los siguientes sistemas: ");
    
    for ($i=1; $i <=$totalSistemas ; $i++) {
        $sistema = $_GET['sistema'.$i];
        $sistemas = $sistemas.$i.".- ".$sistema."\n";
    }

    $pdf->parrafo($sistemas);
    $pdf->parrafo("a $nombreFuncionario con numero de cedula $cedula, cuyo cargo es $nombreCargo para el proceso Electoral $periodo, El funcionario receptor de las credenciales está obligado al complimiento de:
    ");
    $pdf->parrafo("1. Las credenciales entregadas al funcionario para el manejo de los sistemas antes mencionados son para uso institucional e intransferible, y su utilización es de exclusiva responsabilidad del funcionario.\n\n2. El funcionario LOOR MANZANO ANGEL MIGUEL, se compromete a la no divulgación y buen uso de la información facilitada por la institución con total confidencialidad, de incumplir con este compromiso será responsable de las consecuencias establecida en el artículo 190.- 'Apropiación fraudulenta por medios electrónicos' del COIP.\n\n3. En caso de pérdida, olvido o sustracción del usuario y/o clave de acceso para el manejo de los sistemas, el funcionario deberá comunicar al área de tecnología del Consejo Nacional Electoral Delegación Pastaza, de manera inmediata. \n\n4. Las credenciales de acceso serán entregadas de manera persona al funcionario responsable de la misma.");

    $pdf->parrafo("Para la constancia de la actuado y en fe de conformidad y aceptación, se suscribe la presente acta en dos originales de igual valor y efecto para las personas que intervienen en esta diligencia, en la ciudad de $ciudad, a los $dia días del mes de $mes del $año.");
    $pdf->SetTextColor(31,78,121);
    $pdf->SetFont('Times','B',12);
    $pdf->Cell(0,10,utf8_decode('CREDENCIALES'),0,1,'C');
    $pdf->SetTextColor(0,0,0);
    for ($i=1; $i <=$totalSistemas ; $i++) {
        $sistema = $_GET['sistema'.$i];
        $url = $_GET['url'.$i];
        $usuario = $_GET['usuario'.$i];
        $clave = $_GET['clave'.$i];

        $credenciales = $credenciales.$sistema." url = ".$url."\n"."Usuario = ".$usuario." Contraseña = ".$clave."\n\n";
    }

    $pdf->parrafo($credenciales);

    //Firmas de las actas
    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,utf8_decode('ENTREGAN CONFORME'),0,1,'C');
    $pdf->ln(15);
    $pdf->MultiCell(0,5,utf8_decode("NOMBRE \nCARGO"),0,'C');

    $pdf->SetFont('Times','',12);
    $pdf->Cell(0,10,utf8_decode('RECIBÍ CONFORME'),0,1,'C');
    $pdf->ln(15);
    $pdf->MultiCell(0,5,utf8_decode("NOMBRE \nCARGO"),0,'C');

    $pdf->Output();

?>