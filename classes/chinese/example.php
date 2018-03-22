<?php
require('chinese_unicode.php');
//require('fpdf.php');

$data = file_get_contents('data.txt');

// The data is converted in ChineseMultiCell since I gonna use this only to put
// the strings into the PDF.
// If you won't use ChineseMultiCell but only MBFPDF's Cell method, you can uncomment the following
// line and directly convert all data to the right encoding:

//$data = iconv('UTF-8', 'UCS-4BE', $data);

class PDF extends MBFPDF {}

//class MyPDF extends FPDF{}

function prueba(){
//$pdf = new PDF();
$pdf = new PDF();  

$pdf->AddPage();
$pdf->AddMBFont(GB, 'GB1');
//$pdf->SetFont('Arial', 'B', 18);
$pdf->Cell(185, 6, 'Prueba establecimiento', 1, 0, 'L', 1);
$pdf->Ln(10);

/*$pdf->AddMBFont(GB, 'GB1');

$pdf->SetFont(GB,'',8);
$pdf->Cell(20, 6, 'pruebaas', 0, 0, 'L');
$pdf->Cell(20, 6, 'pruebaas', 0, 0, 'L');
$pdf->Cell(20, 6, 'pruebaas', 0, 0, 'L');
$pdf->Cell(20, 6, 'pruebaas', 0, 0, 'L');*/
//die();
$pdf->Output('test.pdf', 'D');
//$documento = '../Usuario/tiquets/prueba.pdf';
  //      $pdf->Output($documento,'F');
}
prueba();
?>
