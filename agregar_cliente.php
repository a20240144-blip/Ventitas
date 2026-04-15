<?php  include("header.php");  ?>


<div class="container">
            <h3>Agregar cliente</h3>
            <form method="post">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Escribe el nombre del cliente">
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Ej. 2111568974">
                </div>
                <div class="mb-3">
                    <label for="direccion" class="form-label">Dirección</label>
                    <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ej. Av Collar 1005 Col Las Cruces">
                </div>

                <div class="text-center mt-3">
                    <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">
                    
                    </input>
                    <a href="index_cliente.php" class="btn btn-danger btn-lg">
                        <i class="fa fa-times"></i> 
                        Cancelar
                    </a>
                </div>
            </form>
        </div>

        <?php
        if(isset($_POST['registrar'])){
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];

            if(empty($nombre) || empty($telefono) || empty($direccion)){
                echo'
                <div class="container text-center col-10">
                    <div class="alert alert-danger mt-3" role="alert">
                        Debes completar todos los datos.
                    </div>
                </div>';
                return;
            } 

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
            
            function insertar($sentencia, $parametros ){
                $bd = conectarBaseDatos();
                $respuesta = $bd->prepare($sentencia);
                return $respuesta->execute($parametros);
            }

            function registrarCliente($nombre, $telefono, $direccion){
                $sentencia = "INSERT INTO clientes (nombre, telefono, direccion) VALUES (?,?,?)";
                $parametros = [$nombre, $telefono, $direccion];
                return insertar($sentencia, $parametros);
            }

            $resultado = registrarCliente($nombre, $telefono, $direccion);
            if($resultado){
                echo'
                <div class="container text-center col-10">
                    <div class="alert alert-success mt-3" role="alert">
                        Cliente registrado con éxito.
                    </div>
                </div>';
            }
            // Duerme durante cinco segundos.
            // En la pagina no se muestrara nada
            // sleep(5);
            //header("Location: index_usuario.php");
            header("Location:clientesalta.php");
        }
    ?>

<?php include("footer.php"); ?>