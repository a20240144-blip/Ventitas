<?php

require('fpdf185/fpdf.php');

$hojas = 3;
$pdf = new FPDF();

for($i=0; $i<$hojas; $i++){
    $pdf->AddPage();
if($i==0){
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(100,10,'Hoja 1');
}

if($i==1){
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(100,10,'Hoja 2');
}

if($i==2){
    $pdf->SetFont('Arial','B', 14);
    $pdf->Cell(100,10,'Hoja 3');
}

}
$pdf->Output();
?>