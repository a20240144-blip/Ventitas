<?php include("header.php"); ?>

<?php

$id = $_GET['id'] ?? null;

if (!$id) {
    echo '
    <div class="container text-center col-10">
        <div class="alert alert-danger mt-3">
            No se ha seleccionado el cliente.
        </div>
    </div>';
    exit;
}

function conectarBaseDatos() {
    $host = "localhost";
    $db   = "ventas";
    $user = "root";
    $pass = "";
    $charset = 'utf8mb4';

    $options = [
        \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_OBJ,
        \PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

    try {
        return new \PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

function select($sentencia, $parametros = []){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute($parametros);
    return $respuesta->fetchAll();
}

function obtenerClientePorId($id){
    $resultado = select("SELECT * FROM clientes WHERE id = ?", [$id]);
    return $resultado ? $resultado[0] : null;
}

$cliente = obtenerClientePorId($id);

if(!$cliente){
    echo "<div class='alert alert-danger'>Cliente no encontrado</div>";
    exit;
}
?>

<div class="container">
    <h3>Editar cliente</h3>

    <form method="post">
        <input type="text" name="nombre" class="form-control mb-2" value="<?php echo $cliente->nombre; ?>">
        <input type="text" name="telefono" class="form-control mb-2" value="<?php echo $cliente->telefono; ?>">
        <input type="text" name="direccion" class="form-control mb-2" value="<?php echo $cliente->direccion; ?>">

        <div class="text-center mt-3">
            <input type="submit" name="guardar" value="Actualizar" class="btn btn-primary">
            <a href="index_cliente.php" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<?php
if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    if(!$nombre || !$telefono || !$direccion){
        echo "<div class='alert alert-danger'>Faltan datos</div>";
        return;
    }

    function editar($sentencia, $parametros ){
        $bd = conectarBaseDatos();
        $respuesta = $bd->prepare($sentencia);
        return $respuesta->execute($parametros);
    }

    $resultado = editar(
        "UPDATE clientes SET nombre=?, telefono=?, direccion=? WHERE id=?",
        [$nombre, $telefono, $direccion, $id]
    );

    if($resultado){
        echo "<div class='alert alert-success'>Cliente actualizado correctamente</div>";
    }

    header("refresh:2;url=index_cliente.php");
}
?>

<?php include("footer.php"); ?>