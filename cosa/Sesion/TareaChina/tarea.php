<?php

require('fpdf185/fpdf.php');
$pdf = new FPDF();
$pdf->AddPage();

$pdf->SetFont('Arial','B', 14);
$pdf->SetDrawColor(0,0,255);
$pdf->SetFillColor(150,25,0);
$pdf->SetTextColor(0,0,255);
$pdf->SetLineWidth(1);
$pdf->AddLink();
$pdf->Ln(10);
$pdf->MultiCell(101, 4, utf8_decode("Producto alimenticio de alto valor nutricional, excelente para deportistas"), 1, 'L');
$pdf->Write(5, 'Visit ');
$pdf->SetAutoPageBreak();
$pdf->Cell(0,1,'Hello World!',0,1,'C','true');
$pdf->Output();


?>