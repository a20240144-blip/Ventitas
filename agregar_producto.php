<?php include("header.php"); ?>

<div class="container">
    <h3>Agregar producto</h3>

    <form method="post">
        <input type="text" name="codigo" placeholder="Código" class="form-control mb-2">
        <input type="text" name="nombre" placeholder="Nombre" class="form-control mb-2">
        <input type="number" name="compra" placeholder="Compra" class="form-control mb-2">
        <input type="number" name="venta" placeholder="Venta" class="form-control mb-2">
        <input type="number" name="existencia" placeholder="Existencia" class="form-control mb-2">

        <input type="submit" name="registrar" value="Guardar" class="btn btn-primary">
    </form>
</div>

<?php
if(isset($_POST['registrar'])){
    $url = "http://localhost/ProyectoFinal/api_productos.php";

    $data = [
        "codigo" => $_POST['codigo'],
        "nombre" => $_POST['nombre'],
        "compra" => $_POST['compra'],
        "venta" => $_POST['venta'],
        "existencia" => $_POST['existencia']
    ];

    $options = [
        "http" => [
            "header" => "Content-Type: application/json",
            "method" => "POST",
            "content" => json_encode($data),
        ]
    ];

    $context = stream_context_create($options);
    $response = file_get_contents($url, false, $context);

    $resultado = json_decode($response, true);

    if(isset($resultado['mensaje'])){
        echo "<div class='alert alert-success'>Guardado correctamente</div>";
    } else {
        echo "<div class='alert alert-danger'>Error</div>";
    }
}
?>

<?php include("footer.php"); ?>