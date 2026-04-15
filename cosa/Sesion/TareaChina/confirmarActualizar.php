<?php
    include ("conexion.php");
    $query="UPDATE datosgenerales SET nombre=:nombre, apellidos=:apellidos, sexo=:sexo WHERE id=:id";
    $gsentence=$conexion->prepare($query);
    $gsentence->bindParam(":id",$_POST["id"]);
    $gsentence->bindParam(":sexo",$_POST["sex"]);
    $gsentence->bindParam(":nombre",$_POST["name"]);
    $gsentence->bindParam(":apellidos",$_POST["lastName"]);
    $gsentence->execute(); 
    header("Location:eliminar.php");
    $conexion=null;
?>