<?php

include '../classes/fpdf181/fpdf.php';

$pdf=new FPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(40,10,'¡Mi primera página pdf con FPDF!');
    $pdf->Output('tiquets/prueba.pdf','F');