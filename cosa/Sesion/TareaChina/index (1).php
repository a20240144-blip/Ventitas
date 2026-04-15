<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesion</title>
</head>
<body>
    <?php
        $mostrar=1;
        if (isset($_POST["sesion"]))
        {
            //Obtenemos los valores
            $userForm = $_POST["user"];//$_GET["user"];
            $passForm = $_POST["passwordUser"];//$_GET["password"];
            //Conectamos a la base de datos
            include("conexion.php");            
            //Generamos la consulta
            $query='SELECT * FROM usuarios WHERE usuario=:usuario and contraseña=:contra';
            $gsentence=$conexion->prepare($query);
            $gsentence->bindParam(':usuario',$userForm);            
            $gsentence->bindParam(':contra',$passForm);
            //$gsentence->execute();
            /* Devuelve el número de usuarios consultados */
            //print("Número de usuarios que coinciden:\n");
            $cuenta = $gsentence->rowCount();
            //print("$cuenta usuarios consultados.\n");

            if ($cuenta==0){
                echo "Acceso Denegado";
                $mostrar=1;
            }
            if ($cuenta==1){
                echo "Acceso Permitido";
                $mostrar=0;
                echo "<script> setTimeout(function(){window.location.href='https://www.youtube.com';},5000) </script>";
            }            
        }
        
    ?>

    <?php if ($mostrar == 1) { ?>
        <h1>INICIO DE SESIÓN</h1>    
        <form action="index.php" method="POST">
            <label for="user">Nombre de usuario:</label>
            <input type="text" name="user" placeholder="Ingresa tú usuario">
            <label for="passwordUser">Contraseña:</label>
            <input type="password" name="passwordUser">
            <button name="sesion">Iniciar Sesión</button>
        </form>    
    <?php } ?>
</body>
</html>