<?php include("header.php"); ?>

<?php

function obtenerUsuarios(){
    $sentencia = "SELECT id, usuario, nombre, telefono, direccion FROM usuarios";
    return select($sentencia);
}

function select($sentencia, $parametros = []){
    $bd = conectarBaseDatos();
    $respuesta = $bd->prepare($sentencia);
    $respuesta->execute($parametros);
    return $respuesta->fetchAll();
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
        $pdo = new \PDO($dsn, $user, $pass, $options);
        return $pdo;
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}

$usuarios = obtenerUsuarios();
?>

<div class="container">
    <h1>
        <a class="btn btn-success btn-lg" href="agregar_usuario.php">
            <i class="fa fa-plus"></i>
            Agregar
        </a>
        Usuarios
    </h1>

    <table class="table">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre</th>
                <th>Teléfono</th>
                <th>Dirección</th>
                <th>Editar</th>
                <th>Eliminar</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach($usuarios as $usuario){ ?>
                <tr>
                    <td><?php echo $usuario->usuario; ?></td>
                    <td><?php echo $usuario->nombre; ?></td>
                    <td><?php echo $usuario->telefono; ?></td>
                    <td><?php echo $usuario->direccion; ?></td>
                    <td>
                        <a class="btn btn-info" href="editar_usuario.php?id=<?php echo $usuario->id; ?>">
                            Editar
                        </a>
                    </td>
                    <td>
                        <a class="btn btn-danger" href="eliminar_usuario.php?id=<?php echo $usuario->id; ?>">
                            Eliminar
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php include("footer.php"); ?>