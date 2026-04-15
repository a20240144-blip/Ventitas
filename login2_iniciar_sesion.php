<!DOCTYPE html>
<!--Apartado tecnico del login para admin -->
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
    <h1>Bienvenido Admin<h1>
    <?php  
    
    session_start();

   


    if(isset($_POST['ingresar'])){
       if(empty($_POST['usuario']) || empty($_POST['password'])){
            echo'
            <div class="container text-center col-10">
                <div class="alert alert-warning mt-3" role="alert">
                    Debes completar todos los datos.
                    <a href="login.php">Regresar</a>
                </div>
            </div>';
            return;
        }        

        $usuario = $_POST['usuario'];
        $password = $_POST['password'];

        session_start();

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

        function verificarPassword($idUsuario, $password){
            $sentencia = "SELECT password FROM usuarios WHERE id = ?";
            $contrasenia = select($sentencia, [$idUsuario])[0]->password;
            $verifica = password_verify($password, $contrasenia);
            if($verifica) return true;
        }

        function iniciarSesion($usuario, $password){
            $sentencia = "SELECT id, usuario, rol FROM usuarios WHERE usuario = ?";
            $resultado = select($sentencia, [$usuario]);
            if($resultado){
                $usuario = $resultado[0];
                $verificaPass = verificarPassword($usuario->id, $password);
                if($verificaPass) return $usuario;
            }
        }

        $datosSesion = iniciarSesion($usuario, $password);



        if(!$datosSesion){
            echo'
            <div class="alert alert-success mt-3" role="alert">
                Nombre de usuario y/o contraseña incorrectas.
                <a href="login.php">Regresar</a>
            </div>';
            return;
        }

        $_SESSION['usuario'] = $datosSesion->usuario;
        $_SESSION['rol']=$datosSesion->rol;
        header("location: indexadmin.php");

        
    }
    ?>
</body>
</html>