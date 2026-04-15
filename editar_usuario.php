<?php include("header.php"); ?>

<?php

$id = $_GET['id'] ?? null;

if (!$id) {
    echo '
    <div class="container text-center col-10">
        <div class="alert alert-danger mt-3">
            No se ha seleccionado el usuario.
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
        die("Error: " . $e->getMessage());
    }
}

function select($sentencia, $parametros = []){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute($parametros);
    return $respuesta->fetchAll();
}

function obtenerUsuarioPorId($id){
    $resultado = select("SELECT id, usuario, nombre, telefono, direccion FROM usuarios WHERE id = ?", [$id]);
    return $resultado ? $resultado[0] : null;
}

$usuario = obtenerUsuarioPorId($id);

if(!$usuario){
    echo "<div class='alert alert-danger'>Usuario no encontrado</div>";
    exit;
}
?>

<div class="container">
    <h3>Editar usuario</h3>

    <form method="post">
        <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="usuario" class="form-control" value="<?php echo $usuario->usuario; ?>">
        </div>

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo $usuario->nombre; ?>">
        </div>

        <div class="mb-3">
            <label>Teléfono</label>
            <input type="text" name="telefono" class="form-control" value="<?php echo $usuario->telefono; ?>">
        </div>

        <div class="mb-3">
            <label>Dirección</label>
            <input type="text" name="direccion" class="form-control" value="<?php echo $usuario->direccion; ?>">
        </div>

        <div class="mt-3 text-center">
            <input type="submit" name="guardar" value="Actualizar" class="btn btn-primary">
            <a href="index_usuario.php" class="btn btn-danger">Cancelar</a>
        </div>
    </form>
</div>

<?php
if(isset($_POST['guardar'])){

    $usuarioPost = $_POST['usuario'];
    $nombre = $_POST['nombre'];
    $telefono = $_POST['telefono'];
    $direccion = $_POST['direccion'];

    if(!$usuarioPost || !$nombre || !$telefono || !$direccion){
        echo "<div class='alert alert-danger'>Faltan datos</div>";
        return;
    }

    function editar($sentencia, $parametros ){
        $bd = conectarBaseDatos();
        $respuesta = $bd->prepare($sentencia);
        return $respuesta->execute($parametros);
    }

    $resultado = editar(
        "UPDATE usuarios SET usuario=?, nombre=?, telefono=?, direccion=? WHERE id=?",
        [$usuarioPost, $nombre, $telefono, $direccion, $id]
    );

    if($resultado){
        echo "<div class='alert alert-success'>Usuario actualizado correctamente</div>";
    }

    header("refresh:2;url=index_usuario.php");
}
?>

<?php include("footer.php"); ?>