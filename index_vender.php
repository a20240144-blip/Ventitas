<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/all.min.css">
    <script src="bootstrap/bootstrap.min.js"></script>
    <script src="bootstrap/bootstrap.bundle.min.js"></script>
    <title>CAPITALS</title>
</head>
<body>

<?php
session_start();

// 🔥 FUNCIONES NECESARIAS

function conectarBaseDatos() {
    return new PDO("mysql:host=localhost;dbname=ventas", "root", "");
}

function calcularTotalLista($lista){
    $total = 0;
    foreach($lista as $producto){
        $total += $producto->cantidad * $producto->venta;
    }
    return $total;
}

function obtenerClientes(){
    $bd = conectarBaseDatos();
    $stmt = $bd->query("SELECT * FROM clientes");
    return $stmt->fetchAll(PDO::FETCH_OBJ);
}

function obtenerClientePorId($id){
    $bd = conectarBaseDatos();
    $stmt = $bd->prepare("SELECT * FROM clientes WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetch(PDO::FETCH_OBJ);
}

// 🔹 SESIÓN
$_SESSION['lista'] = $_SESSION['lista'] ?? [];

// 🔹 DATOS
$total = calcularTotalLista($_SESSION['lista']);
$clientes = obtenerClientes();
$clienteSeleccionado = isset($_SESSION['clienteVenta']) 
    ? obtenerClientePorId($_SESSION['clienteVenta']) 
    : null;
?>

<div class="container mt-3"> 

    <form action="agregar_producto_venta.php" method="post" class="row">
        <div class="col-10">
            <input class="form-control form-control-lg" name="codigo" autofocus type="text" placeholder="Código de barras del producto">
        </div>
        <div class="col">
            <input type="submit" value="Agregar" name="agregar" class="btn btn-success mt-2">
        </div>
    </form>

    <?php if($_SESSION['lista']) {?>

    <table class="table mt-3">
        <thead>
            <tr>
                <th>Código</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
                <th>Quitar</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($_SESSION['lista'] as $lista) { ?>
                <tr>
                    <td><?php echo $lista->codigo; ?></td>
                    <td><?php echo $lista->nombre; ?></td>
                    <td>$<?php echo $lista->venta; ?></td>
                    <td><?php echo $lista->cantidad; ?></td>
                    <td>$<?php echo $lista->cantidad * $lista->venta; ?></td>
                    <td>
                        <a href="quitar_producto_venta.php?id=<?php echo $lista->id ?>" class="btn btn-danger">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>

    <form class="row" method="post" action="establecer_cliente_venta.php">
        <div class="col-10">
            <select class="form-select" name="idCliente">
                <option value="">Selecciona el cliente</option>
                <?php foreach($clientes as $cliente) { ?>
                    <option value="<?php echo $cliente->id ?>">
                        <?php echo $cliente->nombre ?>
                    </option>
                <?php } ?>
            </select>
        </div>
        <div class="col-auto">
            <input class="btn btn-info" type="submit" value="Seleccionar cliente">
        </div>
    </form>

    <?php if($clienteSeleccionado){ ?>
        <div class="alert alert-primary mt-3">
            <b>Cliente seleccionado:</b><br>
            <b>Nombre:</b> <?php echo $clienteSeleccionado->nombre ?><br>
            <b>Teléfono:</b> <?php echo $clienteSeleccionado->telefono ?><br>
            <b>Dirección:</b> <?php echo $clienteSeleccionado->direccion ?><br>
            <a href="quitar_cliente_venta.php" class="btn btn-warning">Quitar</a>
        </div>
    <?php } ?>

    <div class="text-center mt-3">
        <h1>Total: $<?php echo $total; ?></h1>

        <a class="btn btn-primary btn-lg" href="registrar_venta.php">
            <i class="fa fa-check"></i> Terminar venta
        </a>

        <a class="btn btn-danger btn-lg" href="cancelar_venta.php">
            <i class="fa fa-times"></i> Cancelar
        </a>
    </div>

    <?php } ?>

</div>

</body>
</html>