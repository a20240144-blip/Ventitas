<?php
header("Content-Type: application/json");

$conn = new mysqli("localhost", "root", "", "ventas");

if ($conn->connect_error) {
    echo json_encode(["error" => "Error de conexión"]);
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];

// 🔹 GET
if ($method == "GET") {
    $result = $conn->query("SELECT * FROM productos");
    $data = [];

    while($row = $result->fetch_assoc()){
        $data[] = $row;
    }

    echo json_encode($data);
}

// 🔹 POST
if ($method == "POST") {
    $input = json_decode(file_get_contents("php://input"), true);

    $codigo = $input['codigo'] ?? '';
    $nombre = $input['nombre'] ?? '';
    $compra = $input['compra'] ?? '';
    $venta = $input['venta'] ?? '';
    $existencia = $input['existencia'] ?? '';

    if(!$codigo || !$nombre || !$compra || !$venta || !$existencia){
        echo json_encode(["error" => "Datos incompletos"]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO productos (codigo, nombre, compra, venta, existencia) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssddi", $codigo, $nombre, $compra, $venta, $existencia);

    if($stmt->execute()){
        echo json_encode(["mensaje" => "Producto agregado"]);
    } else {
        echo json_encode(["error" => "Error al insertar"]);
    }

    $stmt->close();
}

$conn->close();
?>