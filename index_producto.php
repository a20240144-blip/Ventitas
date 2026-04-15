<?php  include("header.php");  ?>
    <?php
     

        //if(empty($_SESSION['usuario'])) header("location: login.php");
        $nombreProducto = (isset($_POST['nombreProducto'])) ? $_POST['nombreProducto'] : null;

        function conectarBaseDatos() {
            $host = "localhost";
            $db   = "ventas";
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

        function obtenerProductos($busqueda = null){
            $parametros = [];
            $sentencia = "SELECT * FROM productos ";
            if(isset($busqueda)){
                $sentencia .= " WHERE nombre LIKE ? OR codigo LIKE ?";
                array_push($parametros, "%".$busqueda."%", "%".$busqueda."%"); 
            } 
            return select($sentencia, $parametros);
        }

        function obtenerNumeroProductos(){
            $sentencia = "SELECT IFNULL(SUM(existencia),0) AS total FROM productos";
            $fila = select($sentencia);
            if($fila) return $fila[0]->total;
        }

        function obtenerTotalInventario(){
            $sentencia = "SELECT IFNULL(SUM(existencia * venta),0) AS total FROM productos";
            $fila = select($sentencia);
            if($fila) return $fila[0]->total;
        }

        function calcularGananciaProductos(){
            $sentencia = "SELECT IFNULL(SUM(existencia*venta) - SUM(existencia*compra),0) AS total FROM productos";
            $fila = select($sentencia);
            if($fila) return $fila[0]->total;
        }

        $productos = obtenerProductos($nombreProducto);
        
        $cartas = [
            ["titulo" => "No. Productos", "icono" => "fa fa-box", "total" => count($productos), "color" => "#3578FE"],
            ["titulo" => "Total productos", "icono" => "fa fa-shopping-cart", "total" => obtenerNumeroProductos(), "color" => "#4F7DAF"],
            ["titulo" => "Total inventario", "icono" => "fa fa-money-bill", "total" => "$ ". obtenerTotalInventario(), "color" => "#1FB824"],
            ["titulo" => "Ganancia", "icono" => "fa fa-wallet", "total" => "$ ". calcularGananciaProductos(), "color" => "#D55929"],
        ];
    ?>
    <div class="container mt-3">
        <h1>
            <a class="btn btn-success btn-lg" href="agregar_producto.php">
                <i class="fa fa-plus"></i>
                Agregar
            </a>
            Productos
        </h1>
        <!-- Cartas-->
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

        <form action="" method="post" class="input-group mb-3 mt-3">
            <input autofocus name="nombreProducto" type="text" class="form-control" placeholder="Escribe el nombre o código del producto que deseas buscar" aria-label="Nombre producto" aria-describedby="button-addon2">
            <button type="submit" name="buscarProducto" class="btn btn-primary" id="button-addon2">
                <i class="fa fa-search"></i>
                Buscar
            </button>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Precio compra</th>
                    <th>Precio venta</th>
                    <th>Ganancia</th>
                    <th>Existencia</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($productos as $producto){
                ?>
                    <tr>
                        <td><?= $producto->codigo; ?></td>
                        <td><?= $producto->nombre; ?></td>
                        <td><?= '$'.$producto->compra; ?></td>
                        <td><?= '$'.$producto->venta; ?></td>
                        <td><?= '$'. floatval($producto->venta - $producto->compra); ?></td>
                        <td><?= $producto->existencia; ?></td>
                        <td>
                            <a class="btn btn-info" href="editar_producto.php?id=<?= $producto->id; ?>">
                                <i class="fa fa-edit"></i>
                                Editar
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="eliminar_producto.php?id=<?= $producto->id; ?>">
                                <i class="fa fa-trash"></i>
                                Eliminar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
    <?php  include("footer.php");  ?>