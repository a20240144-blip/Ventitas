<?php  include("header.php");  ?>
    <?php
         

        $id = $_GET['id'];
        
        if (!$id) {
            echo'                
                <div class="container text-center col-10">
                    <div class="alert alert-danger mt-3" role="alert">                    
                        No se ha seleccionado el usuario.
                    </div>
                </div>';            
            exit;
        }

        function eliminar($sentencia, $id ){
            $bd = conectarBaseDatos();
            $respuesta = $bd->prepare($sentencia);                        
            return $respuesta->execute([$id]);
        }

        function eliminarUsuario($id){
            $sentencia = "DELETE FROM usuarios WHERE id = ?";            
            return eliminar($sentencia, $id);
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

        $resultado = eliminarUsuario($id);
        
        if(!$resultado){
            echo'                
                <div class="container text-center col-10">
                    <div class="alert alert-danger mt-3" role="alert">                    
                        Error al eliminar.
                    </div>
                </div>';           
            return;
        }

        echo'
                <div class="container text-center col-10">
                    <div class="text-center alert alert-success mt-3" role="alert">
                        Usuario eliminado con éxito.                    
                    </div>
                </div>';

        // Duerme durante cinco segundos.
        // En la pagina no se muestrara nada
        // sleep(5);
        //header("Location: index_usuario.php");
        header("refresh:2;url=index_usuario.php");
    ?>
<?php  include("footer.php");  ?>
