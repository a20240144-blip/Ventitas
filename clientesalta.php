<?php  include("header.php");  ?>
    <?php


        //if(empty($_SESSION['usuario'])) header("location: login.php");

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

        function obtenerClientes(){
            $sentencia = "SELECT * FROM clientes";
            return select($sentencia);
        }

        $clientes = obtenerClientes();
    ?>
    <div class="container">
        <h1>
            <a class="btn btn-success btn-lg" href="agregar_cliente.php">
                <i class="fa fa-plus"></i>
                Agregar
            </a>
            Clientes
        </h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Dirección</th>
                    <th>Editar</th>
                    <th>Eliminar</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach($clientes as $cliente){
                ?>
                    <tr>
                        <td><?php echo $cliente->nombre; ?></td>
                        <td><?php echo $cliente->telefono; ?></td>
                        <td><?php echo $cliente->direccion; ?></td>
                        <td>
                            <a class="btn btn-info" href="editar_cliente.php?id=<?php echo $cliente->id;?>">
                                <i class="fa fa-edit"></i>
                                Editar
                            </a>
                        </td>
                        <td>
                            <a class="btn btn-danger" href="eliminar_cliente.php?id=<?php echo $cliente->id;?>">
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