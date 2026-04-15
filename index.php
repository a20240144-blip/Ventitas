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
    //if(empty($_SESSION['usuario'])) header("location: login.php");

    function conectarBaseDatos() {
        $host = "localhost";
        $db   = "ventas_php";
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

    function select($sentencia, $parametros = []){
        $bd = conectarBaseDatos();
        $respuesta = $bd->prepare($sentencia);
        $respuesta->execute($parametros);
        return $respuesta->fetchAll();
    }

    function obtenerTotalVentas($idUsuario = null){
        $parametros = [];
        $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas";
        if(isset($idUsuario)){
            $sentencia .= " WHERE idUsuario = ?";
            array_push($parametros, $idUsuario);
        }
        $fila = select($sentencia, $parametros);
        if($fila) return $fila[0]->total;
    }

    function obtenerTotalVentasHoy($idUsuario = null){
        $parametros = [];
        $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas WHERE DATE(fecha) = CURDATE() ";
        if(isset($idUsuario)){
            $sentencia .= " AND idUsuario = ?";
            array_push($parametros, $idUsuario);
        }
        $fila = select($sentencia, $parametros);
        if($fila) return $fila[0]->total;
    }

    function obtenerTotalVentasSemana($idUsuario = null){
        $parametros = [];
        $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas  WHERE WEEK(fecha) = WEEK(NOW())";
        if(isset($idUsuario)){
            $sentencia .= " AND  idUsuario = ?";
            array_push($parametros, $idUsuario);
        }
        $fila = select($sentencia, $parametros);
        if($fila) return $fila[0]->total;
    }

    function obtenerTotalVentasMes($idUsuario = null){
        $parametros = [];
        $sentencia = "SELECT IFNULL(SUM(total),0) AS total FROM ventas  WHERE MONTH(fecha) = MONTH(CURRENT_DATE()) AND YEAR(fecha) = YEAR(CURRENT_DATE())";
        if(isset($idUsuario)){
            $sentencia .= " AND  idUsuario = ?";
            array_push($parametros, $idUsuario);
        }
        $fila = select($sentencia, $parametros);
        if($fila) return $fila[0]->total;
    }

    function obtenerNumeroProductos(){
        $sentencia = "SELECT IFNULL(SUM(existencia),0) AS total FROM productos";
        $fila = select($sentencia);
        if($fila) return $fila[0]->total;
    }

    function obtenerNumeroVentas(){
        $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM ventas";
        return select($sentencia)[0]->total;
    }

    function obtenerNumeroUsuarios(){
        $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM usuarios";
        return select($sentencia)[0]->total;
    }

    function obtenerNumeroClientes(){
        $sentencia = "SELECT IFNULL(COUNT(*),0) AS total FROM clientes";
        return select($sentencia)[0]->total;
    }

    function obtenerVentasPorUsuario(){
        $sentencia = "SELECT SUM(ventas.total) AS total, usuarios.usuario, COUNT(*) AS numeroVentas 
        FROM ventas
        INNER JOIN usuarios ON usuarios.id = ventas.idUsuario
        GROUP BY ventas.idUsuario
        ORDER BY total DESC";
        return select($sentencia);
    }
    
    function obtenerVentasPorCliente(){
        $sentencia = "SELECT SUM(ventas.total) AS total, IFNULL(clientes.nombre, 'MOSTRADOR') AS cliente,
        COUNT(*) AS numeroCompras
        FROM ventas
        LEFT JOIN clientes ON clientes.id = ventas.idCliente
        GROUP BY ventas.idCliente
        ORDER BY total DESC";
        return select($sentencia);
    }
    
    function obtenerProductosMasVendidos(){
        $sentencia = "SELECT SUM(productos_ventas.cantidad * productos_ventas.precio) AS total, SUM(productos_ventas.cantidad) AS unidades,
        productos.nombre FROM productos_ventas INNER JOIN productos ON productos.id = productos_ventas.idProducto
        GROUP BY productos_ventas.idProducto
        ORDER BY total DESC
        LIMIT 10";
        return select($sentencia);
    }

    $cartas = [
        ["titulo" => "Total ventas", "icono" => "fa fa-money-bill", "total" => "$  ".obtenerTotalVentas(), "color" => "#A71D45"],
        ["titulo" => "Ventas hoy", "icono" => "fa fa-calendar-day", "total" => "$ ".obtenerTotalVentasHoy(), "color" => "#2A8D22"],
        ["titulo" => "Ventas semana", "icono" => "fa fa-calendar-week", "total" => "$ ".obtenerTotalVentasSemana(), "color" => "#223D8D"],
        ["titulo" => "Ventas mes", "icono" => "fa fa-calendar-alt", "total" => "$ ".obtenerTotalVentasMes(), "color" => "#D55929"],
    ];

    $totales = [
        ["nombre" => "Total productos", "total" => obtenerNumeroProductos(), "imagen" => "img/productos.png"],
        ["nombre" => "Ventas registradas", "total" => obtenerNumeroVentas(), "imagen" => "img/ventas.png"],
        ["nombre" => "Usuarios registrados", "total" => obtenerNumeroUsuarios(), "imagen" => "img/usuarios.png"],
        ["nombre" => "Clientes registrados", "total" => obtenerNumeroClientes(), "imagen" => "img/clientes.png"],
    ];

    $ventasUsuarios = obtenerVentasPorUsuario();
    $ventasClientes = obtenerVentasPorCliente();
    $productosMasVendidos = obtenerProductosMasVendidos();
    ?>

    <div class="container">
        <div class="alert alert-info" role="alert">
            <h1>
                Hola, <?= $_SESSION['usuario']?>
            </h1>
        </div>
        <div class="card-deck row mb-2">
        <?php foreach($totales as $total){?>
            <div class="col-xs-12 col-sm-6 col-md-3" >
                <div class="card text-center">
                    <div class="card-body">
                        <img class="img-thumbnail" src="<?= $total['imagen']?>" alt="">
                        <h4 class="card-title" >
                            <?= $total['nombre']?>
                        </h4>
                        <h2><?= $total['total']?></h2>

                    </div>

                </div>
            </div>
            <?php }?>
        </div>

        <div class="card-deck row">
		<?php foreach($cartas as $carta){?>
		<div class="col-xs-12 col-sm-6 col-md-3" style="color: <?=  $carta['color']?> !important">
			<div class="card text-center">
				<div class="card-body">
					<h4 class="card-title" >
						<i class="fa <?= $carta['icono']?>"></i>
						<?= $carta['titulo']?>
					</h4>
					<h2><?= $carta['total']?></h2>

				</div>

			</div>
		</div>
		<?php }?>
	</div>

        <div class="row mt-2">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4>Ventas por usuarios</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre usuario</th>
                                    <th>Número ventas</th>
                                    <th>Total ventas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ventasUsuarios as $usuario) {?>
                                    <tr>
                                        <td><?= $usuario->usuario?></td>
                                        <td><?= $usuario->numeroVentas?></td>
                                        <td>$<?= $usuario->total?></td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>	 		
            </div>
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h4>Ventas por clientes</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Nombre cliente</th>
                                    <th>Número compras</th>
                                    <th>Total ventas</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($ventasClientes as $cliente) {?>
                                    <tr>
                                        <td><?= $cliente->cliente?></td>
                                        <td><?= $cliente->numeroCompras?></td>
                                        <td>$<?= $cliente->total?></td>
                                    </tr>
                                <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <h4>10 Productos más vendidos</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Unidades vendidas</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($productosMasVendidos as $producto) {?>
                <tr>
                    <td><?= $producto->nombre?></td>
                    <td><?= $producto->unidades?></td>
                    <td>$<?= $producto->total?></td>
                </tr>
                <?php }?>
            </tbody>
        </table>
    </div>	

    <div class="container">
    <h3>cambiar contraseña</h3>
    <form method="post">
        <div class="mb-3">
            <label for="nueva_contraseña" class="form-label">Nueva Contraseña</label>
            <input type="password" name="nueva_contraseña" class="form-control" id="nueva_contraseña" placeholder="Escribe la nueva contraseña">
        </div>

        <div class="text-center mt-3">
            <input type="submit" name="cambiar_contraseña" value="Cambiar Contraseña" class="btn btn-secondary btn-lg">     
        </div>
    </form>
</div>

<?php
// ... (código PHP anterior) ...

if(isset($_POST['cambiar_contraseña'])){
    $nueva_contraseña = $_POST['nueva_contraseña'];
    // Validar que la nueva contraseña no esté vacía
    if(empty($nueva_contraseña)){
        echo '
            <div class="container text-center col-10">
                <div class="alert alert-danger mt-3" role="alert">
                    Debes ingresar una nueva contraseña.
                </div>
            </div>';
    } else {
        $usuario = $_SESSION['usuario']; // Obtener el nombre de usuario de la sesión actual
        // Función para cambiar la contraseña del usuario
        function cambiarContraseña($usuario, $nueva_contraseña) {
            $bd = conectarBaseDatos();
            $password_hash = password_hash($nueva_contraseña, PASSWORD_DEFAULT);
            $sentencia = "UPDATE usuarios SET password = ? WHERE usuario = ?";
            $parametros = [$password_hash, $usuario];

            // Preparar y ejecutar la consulta de actualización
            $stmt = $bd->prepare($sentencia);
            if ($stmt->execute($parametros)) {
                return true; // Contraseña actualizada con éxito
            } else {
                return false; // Error al actualizar la contraseña
            }
        }

        // Intentamos cambiar la contraseña
        $resultado = cambiarContraseña($usuario, $nueva_contraseña);

        if($resultado){
            echo '
            <div class="container text-center col-10">
                <div class="text-center alert alert-success mt-3" role="alert">
                    Contraseña cambiada con éxito.
                </div>
            </div>';
        } else {
            echo '
            <div class="container text-center col-10">
                <div class="text-center alert alert-danger mt-3" role="alert">
                    Error al cambiar la contraseña. Verifica el nombre de usuario.
                </div>
            </div>';
        }
    }
}
?>
</body>
</html>