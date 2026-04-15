<?php include("header.php"); ?>

<?php

$id = $_GET['id'] ?? null;

if (!$id) {
    echo '
    <div class="container text-center col-10">
        <div class="alert alert-danger mt-3">
            No se ha seleccionado el producto.
        </div>
    </div>';
    exit;
}

function conectarBaseDatos() {
    $host = "localhost";
    $db   = "ventas"; // ✅ CORREGIDO
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';

    $options = [
        \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        return new \PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("Error de conexión: " . $e->getMessage());
    }
}

function select($sentencia, $parametros = []){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute($parametros);
    return $respuesta->fetchAll();
}

function obtenerProductoPorId($id){
    $resultado = select("SELECT * FROM productos WHERE id = ?", [$id]);
    return $resultado ? $resultado[0] : null;
}

$producto = obtenerProductoPorId($id);

if(!$producto){
    echo "<div class='alert alert-danger'>Producto no encontrado</div>";
    exit;
}
?>

<div class="container">
    <h3>Editar producto</h3>

    <form method="post">
        <div class="mb-3">
            <label>Código</label>
            <input type="text" name="codigo" class="form-control" value="<?php echo $producto->codigo; ?>">
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $producto->nombre; ?>">
        </div>

        <div class="row">
            <div class="col">
                <label>Compra</label>
                <input type="number" name="compra" class="form-control" value="<?php echo $producto->compra; ?>">
            </div>

            <div class="col">
                <label>Venta</label>
                <input type="number" name="venta" class="form-control" value="<?php echo $producto->venta; ?>">
            </div>

            <div class="col">
                <label>Existencia</label>
                <input type="number" name="existencia" class="form-control" value="<?php echo $producto->existencia; ?>">
            </div>
        </div>

        <div class="mt-3 text-center">
            <input type="submit" name="guardar" value="Actualizar" class="btn btn-primary">
            <a href="index_producto.php" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<?php
if(isset($_POST['guardar'])){

    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $compra = $_POST['compra'];
    $venta = $_POST['venta'];
    $existencia = $_POST['existencia'];

    if(!$codigo || !$nombre || !$compra || !$venta || !$existencia){
        echo "<div class='alert alert-danger'>Faltan datos</div>";
        return;
    }

    function editar($sentencia, $parametros ){
        $bd = conectarBaseDatos();
        $respuesta = $bd->prepare($sentencia);
        return $respuesta->execute($parametros);
    }

    $resultado = editar(
        "UPDATE productos SET codigo=?, nombre=?, compra=?, venta=?, existencia=? WHERE id=?",
        [$codigo, $nombre, $compra, $venta, $existencia, $id]
    );

    if($resultado){
        echo "<div class='alert alert-success'>Producto actualizado correctamente</div>";
    }

    header("refresh:2;url=index_producto.php");
}
?>

<?php include("footer.php"); ?>