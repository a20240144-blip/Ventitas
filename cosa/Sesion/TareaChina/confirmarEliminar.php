<?php
    include ("conexion.php");
    $query="DELETE FROM datosgenerales WHERE id=:id";
    $gsentence=$conexion->prepare($query);
    $gsentence->bindParam(":id",$_GET["id"]);
    $gsentence->execute(); 
    header("Location:eliminar.php");
    $conexion=null;
?>