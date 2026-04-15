<?php 

include ("conexiones.php");
$query="SELECT * FROM usuarios WHERE CURP=''" ;
$gsentence=$conexion->prepare($query);

$gsentence->bindParam(":CURP",$_POST['curp']);
 $gsentence->bindParam(":sexo",$_POST['sexo']);
 $gsentence->bindParam(":nombre",$_POST['nombre']);
 $gsentence->bindParam(":apellidos",$_POST['apellidos']);
 
 $gsentence->execute(); 
?>