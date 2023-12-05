<?php

/**
 * Created by Alexander Numpaque.
 * User: Alexander
 * Date: 08/06/2017
 * Time: 9:50 AM
 *
 * inf_requisiciones.php
 * Archivo para generar el informe de entrada de almacen
 * @package Almacen
 * @param String $mov Id de movimiento
 * @version $Id: inf_requisiciones.php 001 2017-06-08 Alexander Numpaque$
 */
header("Content-Type: text/html;charset=utf-8");
session_start();
@ob_start();
//Archivos adjuntos
require_once('../Conexion/Conexion.php');
$conexion = $_SESSION['conexion'];
require_once('../fpdf/fpdf.php');
$con = new conexionPDO();
//Captura de variables
// $action = base64_decode($_REQUEST['action']);

$usuario = $_SESSION['usuario'];
//Array para igualar los numeros de meses
$meses = array(
    'no', '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril', '05' => 'Mayo', '06' => 'Junio',
    '07' => 'Julio', '08' => 'Agosto', '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
);
//Consulta para obtener los datos de la compañia

$rowC = $con->Listar("SELECT em.*  FROM empleado empl LEFT JOIN empresa em ON empl.Empresa = em.Id 
where empl.usuario = '$usuario'");
$Nit = $rowC[0][1];
$Razonsocial = $rowC[0][2];
$Telefono = $rowC[0][6];
$logo = $rowC[0][7];
//Razon social, tipo de identificación, numero de identificación, Ruta de logo
//Consulta para obtener los datos del movimiento
$diaActual = date('d');
$mes = date('n');
$anno = date('Y');
$action = $_REQUEST['action'];
$NomInf = "INFORME DE VENTA ";
$NomminInf = 'INF-VEN';
$action = $_REQUEST['action'];
switch ($action) {

    case 1: #VENTA DEL DIA
        $Fecha_In_inf = date("Y-m-d");
        $Fecha_Fin_inf = date("Y-m-d");
        break;

    case 2: #VENTA DEL MES ACTUAL
        $Fecha_In_inf = $anno . '-' . $mes . '-' . '01';
        $ultimo_dia_mes = date("t", strtotime($Fecha_inf));
        $Fecha_Fin_inf = $anno . '-' . $mes . '-' . $ultimo_dia_mes;
        break;
    case 3: #VENTA DEL AÑO ACTUAL
        $Fecha_In_inf = $anno . '-' . 01 . '-' . '01';
        $Fecha_Fin_inf = $anno . '-' . 12 . '-' . '31';
        break;
    case 4: #VENTA ENTRE FECHAS
        $Fecha_In_inf = base64_decode($_REQUEST['Ini']);
        $Fecha_Fin_inf = base64_decode($_REQUEST['Fin']);
        break;
}
$sqlEmp = $con->Listar("SELECT Id,Nombre,Apellido,documento FROM empleado where usuario = '$usuario'");
$Nomemple = $sqlEmp[0][1] . " " . $sqlEmp[0][2];
$documento = $sqlEmp[0][3];

//Consulta para obtener el detalle asociado de este movimiento, el cual a de ser la entrada de almacen
//dta hace referencia al detalle asociado, mov_a hace referencia al movimiento asociado

class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;
    function SetWidths($w)
    {
        $this->widths = $w;   //Obtenemos un  array con los anchos de las columnas
    }
    function SetAligns($a)
    {
        $this->aligns = $a;   //Obtenemos un array con los alineamientos de las columnas
    }
    function fill($f)
    {
        $this->fill = $f;     //Juego de arreglos de relleno
    }
    function Row($data)
    {
        //Calculo del alto de una fila
        $nb = 0;
        for ($i = 0; $i < count($data); $i++)
            $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
        $h = 5 * $nb;
        //Si una pagina tiene salto de linea
        $this->CheckPageBreak($h);
        //Dibujar las celdas de las fila
        for ($i = 0; $i < count($data); $i++) {
            $w = $this->widths[$i];
            $a = isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
            //Guardamos las posiciones actuales
            $x = $this->GetX();
            $y = $this->GetY();
            //Dibujamos el borde
            /** @var String $style */
            $this->Rect($x, $y, $w, $h, $style);
            //Imprimimos el texto
            /** @var String $fill */
            $this->MultiCell($w, 4, $data[$i], 'LTR', $a, $fill);
            //Put the position to the right of the cell
            $this->SetXY($x + $w, $y);
        }
        //Go to the next line
        $this->Ln($h - 5);
    }
    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w, $txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace('\r', '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == '\n')
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == '\n') {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == '')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }

    #Funcón cabeza de la página
    function header()
    {
        global $conexion;
        global $NomInf; #Nombre de Informe
        global $NomminInf;
        global $logo;
        #Redeclaración de varibles
        global $Razonsocial;    #Nombre de compañia
        global $Telefono;        #Telefono
        global $Nit;    #Nit
        global $ruta;            #Ruta de logo
        global $diaActual;        #Dia actual
        global $anno;              #Año actual
        global $mes; #Mes actual
        #Validación cuando la variable $ruta, la obtiene la ruta del logo no esta vacia

        if ($logo != '') {
            $this->Image('../IMAGE/BD/' . $logo, 15, 10, 28);
        }

        #Razón social
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(40, 15);
        $this->MultiCell(140, 5, utf8_decode(strtoupper($Razonsocial)), 0, 'C');
        #Tipo documento y número de documento
        $this->SetX(10);
        $this->Ln(1);
        $this->SetFont('Arial', '', 9);
        $this->Cell(200, 5, utf8_decode('Nit:' . PHP_EOL . $Nit), 0, 0, 'C');

        $this->SetX(20);
        $this->Ln(4);
        $this->SetFont('Arial', '', 9);
        $this->Cell(200, 5, utf8_decode('Cel:' . PHP_EOL . $Telefono), 0, 0, 'C');

        #Tipo de comprobante y número de comprobante
        $this->Ln(5);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(200, 5, utf8_decode(ucwords(strtoupper($NomInf . PHP_EOL))) . $anno . $mes . $diaActual . PHP_EOL .  0, 0, 'C');
        $this->Ln(5);
    }

    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'B', 8);
        $this->SetX(10);
        $this->Cell(70, 10, utf8_decode('Fecha: ' . date('d/m/Y')), 0, 0, 'L');
        $this->Cell(70, 10, utf8_decode('Máquina: ' . gethostname()), 0, 0, 'C');
        $this->Cell(60, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'R');
    }
}

$pdf = new PDF_Mc_Table('P', 'mm', 'Letter');        #Creación del objeto pdf
$nb = $pdf->AliasNbPages();        #Objeto de número de pagina
$pdf->AddPage();                #Agregar página
$pdf->Ln(5);
$pdf->Cell(200, 20, '', 1, 0);
$pdf->Ln(0);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(33, 5, utf8_decode('FECHA DE ' . $NomminInf . ':'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, strtoupper("Cucaita , $diaActual DE $meses[$mes] $anno"), 0, 0, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(33, 5, 'NOMBRE:', 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(100, 5, utf8_decode(mb_strtoupper($Nomemple)), 0, 1, 'L');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(33, 5, utf8_decode('CARGO:'), 0, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 5, utf8_decode(mb_strtoupper("Jefe")), 0, 0, 'L');
$pdf->Ln(5);
// $pdf->SetFont('Arial', 'B', 9);
// $pdf->Cell(33, 5, utf8_decode('DESCRIPCIÓN:'), 0, 0, 'R');
// $pdf->SetFont('Arial', '', 9);
// $pdf->MultiCell(165, 5, utf8_decode(ucwords(mb_strtolower("---"))), 0, 'L');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(10, 5, utf8_decode('Nª'), 1, 0, 'C');
$pdf->Cell(60, 5, utf8_decode('PRODUCTOS VENDIDOS'), 1, 0, 'C');
$pdf->Cell(10, 5, 'CANT', 1, 0, 'C');
$pdf->Cell(40, 5, 'VALOR UNITARIO', 1, 0, 'C');
$pdf->Cell(40, 5, 'VALOR IVA', 1, 0, 'C');
$pdf->Cell(40, 5, 'VALOR TOTAL', 1, 0, 'C');


$rowP = $con->Listar("SELECT hv.* FROM historialventa hv WHERE hv.fecha >='$Fecha_In_inf' AND hv.fecha <= '$Fecha_Fin_inf'");



$a = 0;
$iva = 0;
$valorTU = 0;
$valorTI = 0;
$valorTAA = 0;
for ($i = 0; $i < count($rowP); $i++) {
    $a++;
    $valorT = ($rowP[$i][2] * $rowP[$i][3]) + "0";
    $valorTA = number_format($valorT, 2, ',', '.');
    $valorA = number_format($rowP[$i][3], 2, ',', '.');
    $valorI = number_format($valorT * ($iva / 100), 2, ',', '.');
    $valorTU += $rowP[$i][3];
    $valorTI += 0;
    $valorTAA += $valorT;
    $pdf->Ln(5);
    $pdf->SetFont('Arial', '', 9);
    $pdf->SetWidths(array(10, 60, 10, 40, 40, 40));
    $pdf->SetAligns(array('C', 'L', 'C', 'R', 'R', 'R'));
    $pdf->Row(array($a, $rowP[$i][1], $rowP[$i][2], $valorA, $valorI, $valorTA));
    $pago = $pdf->GetY();
    if ($pago >= 220) {

        $nb = $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->AliasNbPages();
    }
}
$pdf->Ln(5);
$pdf->SetX(130);
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(40, 5, 'TOTAL:', 1, 0, 'R');
$pdf->SetFont('Arial', '', 9);
$pdf->SetWidths(array(40));
$pdf->SetAligns(array('R'));
$pdf->Row(array(number_format($valorTAA, 2, ',', '.')));
$pago = $pdf->GetY();
if ($pago >= 215) {

    $nb = $pdf->AliasNbPages();
    $pdf->AddPage();
    $pdf->AliasNbPages();
}
$pdf->Ln(10);
// $pdf->Cell(200, 15, '', 1, 0);
// $pdf->Ln(0);
// $pdf->SetFont('Arial', 'B', 9);
// $pdf->Cell(35, 5, utf8_decode('OBSERVACIONES:'), 0, 0, 'R');
// $pdf->SetFont('Arial', '', 9);
// $pdf->MultiCell(165, 5, utf8_decode(ucwords(mb_strtolower("---"))), 0, 'L');
// $pdf->Ln(10);
// $pdf->Cell(200, 15, '', 1, 0);
// $pdf->Ln(0);
// $pdf->SetFont('Arial', 'B', 9);
// $pdf->Cell(35, 5, utf8_decode('VALOR EN LETRAS:'), 0, 0, 'R');


#Ejecutamos la consulta
$altofinal = $pdf->GetY();
$altop = $pdf->GetPageHeight();
$altofirma = $altop - $altofinal;
$pdf->Ln(10);
#Carga de array $firma con los valores de consulta
$c = 0;
for ($i = 0; $i < count($firma); $i++) {
    $c++;
}
$tfirmas = ($c / 2) * 33;
if ($tfirmas > $altofirma) {
    $pdf->AddPage();
}
$xt = 10;
for ($i = 0; $i < count($sqlEmp); $i++) {

    if ($xt < 50) {
        #Construcción de linea firma
        $xm = 10;
        $pdf->setX($xm);
        $pdf->SetFont('Arial', 'B', 9);
        #Varibles x,y
        $x = $pdf->GetX();
        $y = $pdf->GetY();
        #Salto de linea
        $pdf->Ln(7);
        $pdf->setX($xm);
        #Salto de linea
        $pdf->Ln(15);
        $pdf->setX($xm);
        #Linea para firma
        $pdf->Cell(60, 0, '', 1);
        $pdf->Ln(3);
        $pdf->setX($xm);
        $pdf->Cell(190, 2, utf8_decode($Nomemple), 0, 0, 'L');
        $pdf->Ln(5);
        #Impresión de responsable de documento
        $pdf->Cell(190, 2, utf8_decode("CC-" . $documento), 0, 0, 'L');
        #Salto de linea
        $pdf->Ln(3);
        #Obtención de alto final
        $x2 = $pdf->GetX();
        #Posición final de firma 2
        $pdf->Ln(0);
        $xt = 120;
    } else {
        $xn = 120;
        $pdf->SetY($y);
        #Construcción de linea firma
        $pdf->SetFont('Arial', 'B', 9);
        #Varibles x,y
        $x = $pdf->GetX();
        #alto inicial
        $y = $pdf->GetY();
        #Salto de linea
        $pdf->Ln(7);
        $pdf->setX($xn);
        $pdf->Ln(15);
        $pdf->setX($xn);
        $pdf->Cell(60, 0, '', 1);
        $pdf->Ln(3);
        $pdf->setX($xn);
        $pdf->Cell(190, 2, utf8_decode($Nomemple), 0, 0, 'L');
        $pdf->Ln(5);
        $pdf->setX($xn);
        $pdf->Cell(190, 2, utf8_decode("CC-" . $documento), 0, 0, 'L');
        #Obtención de alto final
        $x2 = $pdf->GetX();
        #Posición del ancho
        $posicionY = $y - 20;
        #Ubicación firma 2
        $pdf->SetXY($x2, $posicionY);
        #Posición final de firma
        $xt = 0;
    }
}

#Final del documento
while (ob_get_length()) {
    ob_end_clean(); #Limpieza del buffer
}
#Salida del documento
$nombre_doc = utf8_decode("informeRequicisionNª'Inventario'.pdf");
$pdf->Output(0, $nombre_doc, 0);
