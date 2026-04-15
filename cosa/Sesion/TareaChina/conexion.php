<?php
$user='root';
$pass='';
$server='localhost';
$db='proyectox';
try {
    $conexion = new PDO("mysql:host=$server;dbname=$db", $user, $pass);
    //echo "Conexión Satisfactoria";
}catch (PDOException $e){
    print "¡Error!: " . $e->getMessage() . "<br/>";
}

?>