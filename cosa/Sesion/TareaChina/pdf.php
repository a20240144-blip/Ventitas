<?php

require('fpdf185/fpdf.php');

    include("conexion.php");
    $query="SELECT * FROM datosgenerales ";
    $gsentence=$conexion->prepare($query);
    $gsentence->execute();

        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',14);
        $pdf->Cell(50,10.5,"Id");
        $pdf->Cell(50,10.5,"Nombre");
        $pdf->Cell(50,10.5,"Apellidos");
        $pdf->Cell(50,10.5,"Sexo",0,1);
        while($row=$gsentence->fetch()){
            $pdf->Cell(50,10.5,$row["id"]);
            $pdf->Cell(50,10.5,$row["nombre"]);
            $pdf->Cell(50,10.5,$row["apellidos"]);
            $pdf->Cell(50,10.5,$row["sexo"],0,1);
        }

$pdf->Output('D', 'fpdf-complete.pdf');

$conexion=null;
