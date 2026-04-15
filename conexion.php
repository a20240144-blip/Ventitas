<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "ventas_php"; 

$conn = new mysqli($host, $user, $password, $db);

if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión"]));
}
?>