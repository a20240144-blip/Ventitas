<?php  include("header.php");  ?>
<div class="container">
        <h3>Agregar usuario</h3>
        <form method="post">
            <div class="mb-3">
                <label for="usuario" class="form-label">Nombre de usuario</label>
                <input type="text" name="usuario" class="form-control" id="usuario" placeholder="Escribe el nombre de usuario. Ej. GchinaCo">
            </div>
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre completo</label>
                <input type="text" name="nombre" class="form-control" id="nombre" placeholder="Escribe el nombre completo del usuario">
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" class="form-control" id="telefono" placeholder="Ej. 3143312345">
            </div>
            <div class="mb-3">
                <label for="direccion" class="form-label">Dirección</label>
                <input type="text" name="direccion" class="form-control" id="direccion" placeholder="Ej. Av Manzanillo 345 Col. Loca">
            </div>


            <!-- The second value will be selected initially -->
<select name="select">
  <option value="0">Vendedor</option>
  <option value="1" selected>Admin</option>
</select>


            <div class="text-center mt-3">
                <input type="submit" name="registrar" value="Registrar" class="btn btn-primary btn-lg">                
                <a href="index_usuario.php" class="btn btn-danger btn-lg">  
                    <i class="fa fa-times"></i>      
                    <i class="bi bi-reply"></i>          
                    Cancelar
                </a>
            </div>
        </form>
    </div> 

    <?php
        if(isset($_POST['registrar'])){
            //Guardamos valores del formulario en variables
            $usuario = $_POST['usuario'];
            $nombre = $_POST['nombre'];
            $telefono = $_POST['telefono'];
            $direccion = $_POST['direccion'];
            $rol=$_POST['select'];

            //Confirmamos que ninguna caja de texto llegue sin información
            if(empty($usuario) ||empty($nombre) || empty($telefono) || empty($direccion)){
                echo'                
                <div class="container text-center col-10">
                    <div class="alert alert-danger mt-3" role="alert">                    
                        Debes completar todos los datos.
                    </div>
                </div>';
                return;
            } 
            //Constantes para utilizar en las funciones
            define("PASSWORD_PREDETERMINADA", "Programacion");
            define("HOY", date("Y-m-d"));
            
            //Funciones 
            function registrarUsuario($usuario, $nombre, $telefono, $direccion,$rol){
                $password = password_hash(PASSWORD_PREDETERMINADA, PASSWORD_DEFAULT);
                $sentencia = "INSERT INTO usuarios (usuario, nombre, telefono, direccion, password,rol) VALUES (?,?,?,?,?,?)";
                $parametros = [$usuario, $nombre, $telefono, $direccion, $password,$rol];
                return insertar($sentencia, $parametros);
            }
            
            function insertar($sentencia, $parametros ){
                $bd = conectarBaseDatos();
                $respuesta = $bd->prepare($sentencia);
                return $respuesta->execute($parametros);
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
            // Enviar información del formulario.
            $resultado = registrarUsuario($usuario, $nombre, $telefono, $direccion,$rol);
            
            if($resultado){
                echo'
                <div class="container text-center col-10">
                    <div class="text-center alert alert-success mt-3" role="alert">
                        Usuario registrado con éxito.                    
                    </div>
                </div>';
            }    
            
            // Duerme durante cinco segundos.
            // En la pagina no se muestrara nada
            // sleep(5);
            //header("Location: index_usuario.php");
            header("refresh:2;url=index_usuario.php");
        }
    ?>

<?php  include("footer.php");  ?>