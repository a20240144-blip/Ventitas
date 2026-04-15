<?php

$user='root';
$pass='';
$server='localhost';
$db='proyecto';

//este comando hace la conexion  entre la base de datos y el codigo , pide la informacion de la conexion

try{
    $conexion= new PDO("mysql:host=$server; dbname=$db",$user,$pass);
    echo "Conexion Satisfactoria";
}catch(PDOException $e){
    print "¡Error:!". $e->getMessage()."<br/>";
}

?>